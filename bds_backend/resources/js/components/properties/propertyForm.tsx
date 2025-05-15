// ✅ All necessary imports stay the same
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Property } from '@/types';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useForm } from '@inertiajs/react';
import { FormEventHandler, useEffect, useState } from 'react';

interface PropertyFormProps {
    properties: Property[];
    property?: Property;
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
            <form onSubmit={handleSubmit} className="space-y-6 max-w-3xl mx-auto" encType="multipart/form-data">
                <div className="grid gap-4">
                    <div>
                        <Label htmlFor="name">Tên bất động sản</Label>
                        <Input id="name" value={data.name} onChange={(e) => setData('name', e.target.value)} />
                        <InputError message={errors.name} />
                    </div>

                    <div>
                        <Label htmlFor="description">Mô tả</Label>
                        <Input id="description" value={data.description} onChange={(e) => setData('description', e.target.value)} />
                        <InputError message={errors.description} />
                    </div>

                    <div>
                        <Label htmlFor="price">Giá</Label>
                        <Input id="price" type="number" value={data.price} onChange={(e) => setData('price', e.target.value.replace(/,/g, ''))} />
                        <InputError message={errors.price} />
                    </div>

                    <div>
                        <Label>Dự án</Label>
                        <Select value={String(data.project_id)} onValueChange={(value) => setData('project_id', value)}>
                            <SelectTrigger><SelectValue placeholder="Chọn dự án" /></SelectTrigger>
                            <SelectContent>
                                {projects.map((p) => (
                                    <SelectItem key={p.id} value={String(p.id)}>{p.name}</SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>

                    <div>
                        <Label>Danh mục</Label>
                        <Select value={String(data.category_id)} onValueChange={(value) => setData('category_id', value)}>
                            <SelectTrigger><SelectValue placeholder="Chọn danh mục" /></SelectTrigger>
                            <SelectContent>
                                {categories.map((c) => (
                                    <SelectItem key={c.id} value={String(c.id)}>{c.name}</SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>

                    <div>
                        <Label>Loại giao dịch</Label>
                        <Select value={String(data.listing_type_id)} onValueChange={(value) => setData('listing_type_id', value)}>
                            <SelectTrigger><SelectValue placeholder="Chọn loại giao dịch" /></SelectTrigger>
                            <SelectContent>
                                {listingTypes.map((l) => (
                                    <SelectItem key={l.id} value={String(l.id)}>{l.name}</SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>

                    <div>
                        <Label>Tỉnh/Thành phố</Label>
                        <Select value={String(data.province_id || '')} onValueChange={(value) => setData('province_id', value)}>
                        <SelectTrigger><SelectValue placeholder="Chọn tỉnh/thành phố" /></SelectTrigger>
                            <SelectContent>
                                {provinces?.map((p) => (
                                    <SelectItem key={p.id} value={p.code}>{p.name}</SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        <InputError message={errors.province_id} />
                    </div>

                    <div>
                        <Label>Quận/Huyện</Label>
                        <Select value={String(data.district_id || '')} onValueChange={(value) => setData('district_id', value)}>

                        <SelectTrigger><SelectValue placeholder="Chọn quận/huyện" /></SelectTrigger>
                            <SelectContent>
                                {districts?.filter(d => d.parent_code === data.province_id).map((d) => (
                                    <SelectItem key={d.id} value={d.code}>{d.name}</SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        <InputError message={errors.district_id} />
                    </div>

                    <div>
                        <Label>Phường/Xã</Label>
                        <Select value={String(data.ward_id || '')} onValueChange={(value) => {
                            setData('ward_id', value)
                            updateAddress(String(data.province_id), String(data.district_id), value)
                        }}>

                        <SelectTrigger><SelectValue placeholder="Chọn phường/xã" /></SelectTrigger>
                            <SelectContent>
                                {wards?.filter(w => w.parent_code === data.district_id).map((w) => (
                                    <SelectItem key={w.id} value={w.code}>{w.name}</SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        <InputError message={errors.ward_id} />
                    </div>

                    <div>
                        <Label>Địa chỉ chi tiết</Label>
                        <Input
                            value={addressDetail}
                            onChange={(e) => {
                                setAddressDetail(e.target.value);
                                setData('address', `${e.target.value}, ${autoAddress}`.trim().replace(/^,/, ''));
                            }}
                            placeholder="Ví dụ: Số 10 ngõ 5..."
                        />
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                        {amenities.map((a) => (
                            <div key={a.id}>
                                <Label className="flex items-center gap-2">
                                    <input type="checkbox" checked={isAmenityChecked(a.id)} onChange={() => handleAmenityToggle(a.id)} />
                                    {a.name}
                                </Label>
                                {isAmenityChecked(a.id) && (
                                    <Input
                                        value={getAmenityValue(a.id)}
                                        onChange={(e) => handleAmenityValueChange(a.id, e.target.value)}
                                        placeholder="Nhập giá trị..."
                                    />
                                )}
                            </div>
                        ))}
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                        {attributes.map((a) => (
                            <div key={a.id}>
                                <Label className="flex items-center gap-2">
                                    <input type="checkbox" checked={isAttributeChecked(a.id)} onChange={() => handleAttributeToggle(a.id)} />
                                    {a.name}
                                </Label>
                                {isAttributeChecked(a.id) && (
                                    <Input
                                        value={getAttributeValue(a.id)}
                                        onChange={(e) => handleAttributeValueChange(a.id, e.target.value)}
                                        placeholder="Nhập giá trị..."
                                    />
                                )}
                            </div>
                        ))}
                    </div>

                    <div>
                        <Label>Ảnh đại diện</Label>
                        <Input type="file" accept="image/*" onChange={(e) => setData('image', e.target.files?.[0] || null)} />
                        <InputError message={errors.image} />
                    </div>

                    <div className="flex gap-2">
                        <Button type="submit" disabled={processing}>
                            {processing ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Thêm mới'}
                        </Button>
                        {isEdit && editingProperty && (
                            <Button variant="destructive" type="button" onClick={() => handleDelete(editingProperty.id)} disabled={processing}>
                                Xoá
                            </Button>
                        )}
                    </div>
                </div>
            </form>
        </div>
    );
}
