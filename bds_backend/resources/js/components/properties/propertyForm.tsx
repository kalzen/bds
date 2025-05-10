// ✅ All necessary imports stay the same
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Property } from '@/types';
import { useForm } from '@inertiajs/react';
import { FormEventHandler, useEffect, useState } from 'react';

interface PropertyFormProps {
    properties: Property[];
    property?: Property; // 👈 đây là dữ liệu property từ controller khi ở edit
    categories: { id: number; name: string }[];
    projects: { id: number; name: string }[];
    amenities: { id: number; name: string }[];
    attributes: { id: number; name: string }[];
    listingTypes?: { id: number; name: string }[];
    provinces?: { id: number; name: string; code: string }[];
    districts?: { id: number; name: string; code: string; parent_code: string }[];
    wards?: { id: number; name: string; code: string; parent_code: string }[];
    locations?: { id: number; name: string }[];
    currentUserId: number;
}

interface PropertyFormData {
    user_id: number | string;
    project_id: number | string;
    listing_type_id: number | string;
    category_id: number | string;
    location_id: number | string;
    province_id: number | string;
    district_id: number | string;
    ward_id: number | string;
    name: string;
    description: string;
    price: number | string;
    image: File | null;
    amenities: {
        amenity_id: number;
        value: string | number;
    }[];
    attributes: {
        attribute_id: number;
        value: string | number;
    }[];
    address: string;

    [key: string]: any;
}

export default function PropertyForm({
                                         properties,
                                         property,
                                         categories,
                                         projects,
                                         amenities,
                                         attributes,
                                         provinces,
                                         districts,
                                         wards,
                                         listingTypes = [],
                                         locations = [],
                                         currentUserId,
                                     }: PropertyFormProps) {
    const [editingProperty, setEditingProperty] = useState<Property | null>(null);
    const [autoAddress, setAutoAddress] = useState('');
    const [addressDetail, setAddressDetail] = useState('');

    const initialFormData: PropertyFormData = {
        user_id: currentUserId,
        project_id: '',
        listing_type_id: '',
        category_id: '',
        location_id: '',
        province_id: '',
        district_id: '',
        ward_id: '',
        name: '',
        description: '',
        price: '',
        image: null,
        amenities: [],
        attributes: [],
        address: '',
    };

    const { data, setData, post, put, delete: destroy, processing, errors, reset, transform } = useForm<PropertyFormData>(initialFormData);

    const isEdit = Boolean(editingProperty);

    useEffect(() => {
        if (property) {
            console.log(property);
            setEditingProperty(property); // 👈 auto populate khi vào trang edit
        }
    }, [property]);

    useEffect(() => {
        if (editingProperty) {
            setData({
                user_id: editingProperty.user_id || currentUserId,
                project_id: editingProperty.project_id || '',
                listing_type_id: editingProperty.listing_type_id || '',
                category_id: editingProperty.category_id || '',
                location_id: editingProperty.location_id || '',
                province_id: '',
                district_id: '',
                ward_id: '',
                name: editingProperty.name || '',
                description: editingProperty.description || '',
                price: editingProperty.price || '',
                image: null,
                amenities: editingProperty.amenities?.map((a) => ({
                    amenity_id: a.amenitie.id,
                    value: a.value || '',
                })) || [],
                attributes:
                    editingProperty.attributes?.map((attr) => ({
                        attribute_id: attr.attribute.id,
                        value: attr.value,
                    })) || [],
                address: editingProperty.location?.address || '',
            });


            const fullAddress = editingProperty.location?.address || '';
            const [detail = '', ...rest] = fullAddress.split(',').map((s) => s.trim());

            setAddressDetail(detail);
            setAutoAddress(rest.join(', '));
        }
    }, [editingProperty]);

    const handleProvinceChange = (provinceId: string) => {
        setData('province_id', provinceId);
        setData('district_id', '');
        setData('ward_id', '');
        updateAddress(provinceId, '', '');
    };

    const handleDistrictChange = (districtId: string) => {
        const currentProvinceId = data.province_id;
        setData('district_id', districtId);
        setData('ward_id', '');
        updateAddress(currentProvinceId as string, districtId, '');
    };

    const updateAddress = (provinceId: string, districtId: string, wardId: string) => {
        const province = provinces?.find((p) => p.code === provinceId);
        const district = districts?.find((d) => d.code === districtId);
        const ward = wards?.find((w) => w.code === wardId);

        const autoAddr = `${ward?.name || ''}, ${district?.name || ''}, ${province?.name || ''}`.trim();
        setAutoAddress(autoAddr);
        const fullAddr = `${addressDetail}, ${autoAddr}`.trim().replace(/^,/, '');
        setData('address', fullAddr);
    };

    const isAmenityChecked = (id: number) => data.amenities.some((a) => a.amenity_id === id);
    const getAmenityValue = (id: number) => data.amenities.find((a) => a.amenity_id === id)?.value || '';

    const handleAmenityToggle = (id: number) => {
        const exists = data.amenities.find((a) => a.amenity_id === id);
        if (exists) {
            setData(
                'amenities',
                data.amenities.filter((a) => a.amenity_id !== id),
            );
        } else {
            setData('amenities', [...data.amenities, { amenity_id: id, value: '1' }]);
        }
    };

    const handleAmenityValueChange = (id: number, value: string) => {
        const updated = data.amenities.map((a) =>
            a.amenity_id === id ? { ...a, value } : a
        );
        setData('amenities', updated);
    };


    const handleAttributeToggle = (id: number) => {
        const exists = data.attributes.find((attr) => attr.attribute_id === id);
        if (exists) {
            setData(
                'attributes',
                data.attributes.filter((attr) => attr.attribute_id !== id),
            );
        } else {
            setData('attributes', [...data.attributes, { attribute_id: id, value: '1' }]);
        }
    };

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();
        console.log(data);
        const formData = new FormData();
        transform((data) => {

            Object.entries(data).forEach(([key, value]) => {
                if (key === 'image' && value instanceof File) {
                    formData.append('image', value);
                } else if (key === 'amenities') {
                    value.forEach((attr: any, i: number) => {
                        formData.append(`amenities[${i}][amenity_id]`, String(attr.amenity_id));
                        formData.append(`amenities[${i}][value]`, String(attr.value));
                    });
                } else if (key === 'attributes') {
                    value.forEach((attr: any, i: number) => {
                        formData.append(`attributes[${i}][attribute_id]`, String(attr.attribute_id));
                        formData.append(`attributes[${i}][value]`, String(attr.value));
                    });
                } else {
                    formData.append(key, value as string);
                }
            });
            for (const pair of formData.entries()) {
                console.log(`${pair[0]}: ${pair[1]}`);
            }
            return formData;
        });


        if (isEdit && editingProperty) {
            console.log(data)
            formData.append('_method', 'PUT');

            post(
                isEdit && editingProperty
                    ? route('properties.update', editingProperty.id)
                    : route('properties.store'),
                {
                    forceFormData: true,
                    onSuccess: () => {
                        if (isEdit) setEditingProperty(null);
                        reset();
                    },
                }
            );
        } else {
            post(route('properties.store'));
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Bạn có chắc chắn muốn xoá bất động sản này?')) {
            destroy(route('properties.destroy', id));
        }
    };

    const isAttributeChecked = (id: number) => data.attributes.some((attr) => attr.attribute_id === id);
    const getAttributeValue = (id: number) => data.attributes.find((attr) => attr.attribute_id === id)?.value || '';
    const handleAttributeValueChange = (id: number, value: string) => {
        const updatedAttributes = data.attributes.map((attr) => (attr.attribute_id === id ? { ...attr, value } : attr));
        setData('attributes', updatedAttributes);
    };

    return (
        <div className="space-y-6 p-4">
            <form onSubmit={handleSubmit} className="max-w-xl space-y-4" encType="multipart/form-data">
                <Input placeholder="Tên bất động sản" value={data.name} onChange={(e) => setData('name', e.target.value)} />
                <InputError message={errors.name} />

                <Input placeholder="Mô tả" value={data.description} onChange={(e) => setData('description', e.target.value)} />
                <InputError message={errors.description} />

                <Input
                    type="number"
                    placeholder="Giá"
                    value={data.price}
                    onChange={(e) =>
                        setData('price', e.target.value.replace(/,/g, ''))
                    }
                />
                <InputError message={errors.price} />

                <select value={data.project_id} onChange={(e) => setData('project_id', e.target.value)} className="w-full rounded border px-2 py-1">
                    <option value="">Chọn dự án</option>
                    {projects.map((p) => (
                        <option key={p.id} value={p.id}>
                            {p.name}
                        </option>
                    ))}
                </select>

                <select value={data.category_id} onChange={(e) => setData('category_id', e.target.value)} className="w-full rounded border px-2 py-1">
                    <option value="">Chọn danh mục</option>
                    {categories.map((c) => (
                        <option key={c.id} value={c.id}>
                            {c.name}
                        </option>
                    ))}
                </select>

                <select
                    value={data.listing_type_id}
                    onChange={(e) => setData('listing_type_id', e.target.value)}
                    className="w-full rounded border px-2 py-1"
                >
                    <option value="">Chọn loại giao dịch</option>
                    {listingTypes.map((l) => (
                        <option key={l.id} value={l.id}>
                            {l.name}
                        </option>
                    ))}
                </select>

                {/* Province/District/Ward Selects */}
                <select
                    value={data.province_id || ''}
                    onChange={(e) => handleProvinceChange(e.target.value)}
                    className="w-full rounded border px-2 py-1"
                >
                    <option value="">Chọn tỉnh/thành phố</option>
                    {provinces?.map((province) => (
                        <option key={province.id} value={province.code}>
                            {province.name}
                        </option>
                    ))}
                </select>
                <InputError message={errors.province_id} />

                <select
                    value={data.district_id || ''}
                    onChange={(e) => handleDistrictChange(e.target.value)}
                    className="w-full rounded border px-2 py-1"
                >
                    <option value="">Chọn quận/huyện</option>
                    {districts
                        ?.filter((d) => d.parent_code === data.province_id)
                        .map((district) => (
                            <option key={district.id} value={district.code}>
                                {district.name}
                            </option>
                        ))}
                </select>
                <InputError message={errors.district_id} />

                <select
                    value={data.ward_id || ''}
                    onChange={(e) => {
                        const wardCode = e.target.value;
                        setData('ward_id', wardCode);
                        updateAddress(data.province_id as string, data.district_id as string, wardCode);
                    }}
                    className="w-full rounded border px-2 py-1"
                >
                    <option value="">Chọn phường/xã</option>
                    {wards
                        ?.filter((w) => w.parent_code === data.district_id)
                        .map((ward) => (
                            <option key={ward.id} value={ward.code}>
                                {ward.name}
                            </option>
                        ))}
                </select>
                <InputError message={errors.ward_id} />

                {/* Address Detail Input */}
                <div className="mt-2">
                    <label>Địa chỉ</label>
                    <input
                        type="text"
                        value={addressDetail}
                        onChange={(e) => {
                            const detail = e.target.value;
                            setAddressDetail(detail);
                            setData('address', `${detail}, ${autoAddress}`.trim().replace(/^,/, ''));
                        }}
                        className="w-full rounded border px-2 py-1"
                        placeholder="Ví dụ: Số 10 ngõ 5..."
                    />
                </div>

                <div className="grid grid-cols-2 gap-2">
                    {amenities.map((a) => (
                        <div key={a.id}>
                            <label className="flex items-center gap-2">
                                <input type="checkbox" checked={isAmenityChecked(a.id)} onChange={() => handleAmenityToggle(a.id)} />
                                {a.name}
                            </label>
                            {isAmenityChecked(a.id) && (
                                <input
                                    type="text"
                                    value={getAmenityValue(a.id)}
                                    onChange={(e) => handleAmenityValueChange(a.id, e.target.value)}
                                    className="mt-1 w-full rounded border px-2 py-1"
                                    placeholder="Nhập giá trị..."
                                />
                            )}
                        </div>
                    ))}
                </div>


                <div className="grid grid-cols-2 gap-2">
                    {attributes.map((a) => (
                        <div key={a.id}>
                            <label className="flex items-center gap-2">
                                <input type="checkbox" checked={isAttributeChecked(a.id)} onChange={() => handleAttributeToggle(a.id)} />
                                {a.name}
                            </label>
                            {isAttributeChecked(a.id) && (
                                <input
                                    type="text"
                                    value={getAttributeValue(a.id)}
                                    onChange={(e) => handleAttributeValueChange(a.id, e.target.value)}
                                    className="mt-1 w-full rounded border px-2 py-1"
                                    placeholder="Nhập giá trị..."
                                />
                            )}
                        </div>
                    ))}
                </div>

                {/* Image Upload */}
                <div className="flex gap-2">
                    <input type="file" accept="image/*" onChange={(e) => setData('image', e.target.files?.[0] || null)} />
                    <InputError message={errors.image} />
                </div>

                {/* Submit/Delete */}
                <div className="flex gap-2">
                    <Button type="submit" disabled={processing}>
                        {processing ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Thêm mới'}
                    </Button>
                    {isEdit && editingProperty && (
                        <Button type="button" onClick={() => handleDelete(editingProperty.id)} disabled={processing}>
                            Xoá
                        </Button>
                    )}
                </div>
            </form>
        </div>
    );
}
