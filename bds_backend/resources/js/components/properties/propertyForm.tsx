import { useForm } from '@inertiajs/react';
import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';
import { Property, Provinces, District, Ward } from '@/types';

interface PropertyFormProps {
    properties: Property[];
    categories: { id: number; name: string }[];
    projects: { id: number; name: string }[];
    amenities: { id: number; name: string }[];
    listingTypes?: { id: number; name: string }[];
    provinces?: { id: number; name: string; code: string }[];
    districts?: { id: number; name: string; code: string; parent_code: string }[];
    wards?: { id: number; name: string; code: string; parent_code: string  }[];
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
    amenities: number[];
    attributes: {
        id: number;
        value: string | number;
    }[];
    address: string;  // Thêm trường address
    [key: string]: any;
}

export default function PropertyForm({
                                         properties,
                                         categories,
                                         projects,
                                         amenities,
                                         provinces,
                                         districts,
                                         wards,
                                         listingTypes = [],
                                         locations = [],
                                         currentUserId,
                                     }: PropertyFormProps) {
    const [editingProperty, setEditingProperty] = useState<Property | null>(null);
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
        address: '',  // Khởi tạo trường address
    };

    const {
        data,
        setData,
        post,
        put,
        delete: destroy,
        processing,
        errors,
        reset,
        transform,
    } = useForm<PropertyFormData>(initialFormData);

    const isEdit = Boolean(editingProperty);

    useEffect(() => {
        if (editingProperty) {
            setData({
                ...data,
                user_id: editingProperty.user_id || currentUserId,
                project_id: editingProperty.project_id || '',
                listing_type_id: editingProperty.listing_type_id || '',
                category_id: editingProperty.category_id || '',
                location_id: editingProperty.location_id || '',
                name: editingProperty.name || '',
                description: editingProperty.description || '',
                price: editingProperty.price || '',
                amenities: editingProperty.amenities?.map(a => a.amenity.id) || [],
                attributes: editingProperty.attributes?.map(attr => ({
                    id: attr.attribute.id,
                    value: attr.value,
                })) || [],
                image: null,
                address: editingProperty.address || '',  // Gán giá trị address khi chỉnh sửa
            });
        } else {
            reset();
            setData('user_id', currentUserId);
        }
    }, [editingProperty]);

    const handleProvinceChange = (provinceId: string) => {
        // console.log(provinceId)
        setData('province_id', provinceId);
        setData('district_id', '');
        setData('ward_id', '');
        updateAddress(provinceId, '', '');
    };

    const handleDistrictChange = (districtId: string) => {
        setData('district_id', districtId);
        setData('ward_id', '');
        updateAddress(data.parent_code, districtId, '');
    };

    const updateAddress = (provinceId: string, districtId: string, wardId: string) => {
        // @ts-ignore
        const province = provinces?.find(p => p.id === provinceId);
        // @ts-ignore
        const district = districts?.find(d => d.code === districtId);
        // @ts-ignore
        const ward = wards?.find(w => w.code === wardId);

        const address = `${ward?.name || ''}, ${district?.name || ''}, ${province?.name || ''}`.trim();
        setData('address', address);
    };


    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        transform((data) => {
            const formData = new FormData();
            Object.entries(data).forEach(([key, value]) => {
                if (key === 'image' && value instanceof File) {
                    formData.append('image', value);
                } else if (key === 'amenities') {
                    value.forEach((v: number, i: number) => formData.append(`amenities[${i}]`, String(v)));
                } else if (key === 'attributes') {
                    value.forEach((attr: any, i: number) => {
                        formData.append(`attributes[${i}][id]`, String(attr.id));
                        formData.append(`attributes[${i}][value]`, String(attr.value));
                    });
                } else {
                    formData.append(key, value as string);
                }
            });
            return formData;
        });

        if (isEdit && editingProperty) {
            put(route('properties.update', editingProperty.id), {
                onSuccess: () => setEditingProperty(null),
            });
        } else {
            post(route('properties.store'));
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Bạn có chắc chắn muốn xoá bất động sản này?')) {
            destroy(route('properties.destroy', id));
        }
    };

    const handleAmenityChange = (id: number) => {
        const updated = data.amenities.includes(id)
            ? data.amenities.filter((aid) => aid !== id)
            : [...data.amenities, id];
        setData('amenities', updated);
    };

    return (
        <div className="p-4 space-y-6">
            <form onSubmit={handleSubmit} className="space-y-4 max-w-xl" encType="multipart/form-data">
                <Input placeholder="Tên bất động sản" value={data.name} onChange={(e) => setData('name', e.target.value)} />
                <InputError message={errors.name} />

                <Input placeholder="Mô tả" value={data.description} onChange={(e) => setData('description', e.target.value)} />
                <InputError message={errors.description} />

                <Input type="number" placeholder="Giá" value={data.price} onChange={(e) => setData('price', e.target.value)} />
                <InputError message={errors.price} />

                <input type="file" accept="image/*" onChange={(e) => setData('image', e.target.files?.[0] || null)} />
                <InputError message={errors.image} />

                <select value={data.project_id} onChange={(e) => setData('project_id', e.target.value)} className="w-full border rounded px-2 py-1">
                    <option value="">Chọn dự án</option>
                    {projects.map(p => <option key={p.id} value={p.id}>{p.name}</option>)}
                </select>

                <select value={data.category_id} onChange={(e) => setData('category_id', e.target.value)} className="w-full border rounded px-2 py-1">
                    <option value="">Chọn danh mục</option>
                    {categories.map(c => <option key={c.id} value={c.id}>{c.name}</option>)}
                </select>

                <select value={data.listing_type_id} onChange={(e) => setData('listing_type_id', e.target.value)} className="w-full border rounded px-2 py-1">
                    <option value="">Chọn loại giao dịch</option>
                    {listingTypes.map(l => <option key={l.id} value={l.id}>{l.name}</option>)}
                </select>

                <select
                    value={data.province_id || ''}
                    onChange={(e) => handleProvinceChange(e.target.value)}
                    className="w-full border rounded px-2 py-1"
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
                    className="w-full border rounded px-2 py-1"
                >
                    <option value="">Chọn quận/huyện</option>
                    {districts
                        ?.filter((district) => district.parent_code === data.province_id)
                        .map((district) => (
                            <option key={district.id} value={district.code}>
                                {district.name}
                            </option>
                        ))}
                </select>
                <InputError message={errors.district_id} />

                <select
                    value={data.ward_id || ''}
                    onChange={(e) => setData('ward_id', e.target.value)}
                    className="w-full border rounded px-2 py-1"
                >
                    <option value="">Chọn phường/xã</option>
                    {wards
                        ?.filter((ward) => ward.parent_code === data.district_id)
                        .map((ward) => (
                            <option key={ward.id} value={ward.id}>
                                {ward.name}
                            </option>
                        ))}
                </select>
                <InputError message={errors.ward_id} />

                {/* Hiển thị địa chỉ */}
                <div className="mt-2">
                    <label>Địa chỉ</label>
                    <input
                        type="text"
                        readOnly
                        value={data.address}
                        className="w-full border rounded px-2 py-1"
                    />
                </div>

                <div className="grid grid-cols-2 gap-2">
                    {amenities.map((a) => (
                        <label key={a.id} className="flex items-center gap-2">
                            <input type="checkbox" checked={data.amenities.includes(a.id)} onChange={() => handleAmenityChange(a.id)} />
                            {a.name}
                        </label>
                    ))}
                </div>

                <div className="space-y-2">
                    {data.attributes.map((attr, i) => (
                        <div key={i} className="flex items-center gap-2">
                            <span>ID {attr.id}</span>
                            <Input value={attr.value} onChange={(e) => {
                                const updated = [...data.attributes];
                                updated[i].value = e.target.value;
                                setData('attributes', updated);
                            }} />
                        </div>
                    ))}
                </div>

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
