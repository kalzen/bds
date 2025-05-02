import { useForm } from '@inertiajs/react';
import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';
import { Property } from '@/types';

interface PropertyFormProps {
    properties: Property[];
    categories: { id: number; name: string }[];
    projects: { id: number; name: string }[];
    amenities: { id: number; name: string }[];
    listingTypes?: { id: number; name: string }[];
    locations?: { id: number; name: string }[];
    currentUserId: number; // 👈 Thêm dòng này
}

interface PropertyFormData {
    user_id: number | string;
    project_id: number | string;
    listing_type_id: number | string;
    category_id: number | string;
    location_id: number | string;
    name: string;
    description: string;
    address: string;
    price: number | string;
    area: number | string;
    image: File | null;
    amenities: number[];
    attributes: {
        id: number;
        value: string | number;
    }[];
    [key: string]: any;
}

export default function PropertyForm({
                                         properties,
                                         categories,
                                         projects,
                                         amenities,
                                         listingTypes = [],
                                         locations = [],
                                         currentUserId, // 👈 Nhận từ props
                                     }: PropertyFormProps) {
    const [editingProperty, setEditingProperty] = useState<Property | null>(null);

    const initialFormData: PropertyFormData = {
        user_id: currentUserId, // 👈 Gán mặc định
        project_id: '',
        listing_type_id: '',
        category_id: '',
        location_id: '',
        name: '',
        description: '',
        address: '',
        price: '',
        area: '',
        image: null,
        amenities: [],
        attributes: [],
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
                image: null, // không truyền lại file
            });
        } else {
            reset();
            setData('user_id', currentUserId); // reset lại user_id khi tạo mới
        }
    }, [editingProperty]);

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

                <Input placeholder="Địa chỉ" value={data.address} onChange={(e) => setData('address', e.target.value)} />
                <InputError message={errors.address} />

                <Input type="number" placeholder="Giá" value={data.price} onChange={(e) => setData('price', e.target.value)} />
                <InputError message={errors.price} />

                <Input type="number" placeholder="Diện tích (m²)" value={data.area} onChange={(e) => setData('area', e.target.value)} />
                <InputError message={errors.area} />

                <input type="file" accept="image/*" onChange={(e) => setData('image', e.target.files?.[0] || null)} />
                <InputError message={errors.image} />

                <select value={data.project_id} onChange={(e) => setData('project_id', e.target.value)} className="w-full border rounded px-2 py-1">
                    <option value="" >Chọn dự án</option>
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

                <select value={data.location_id} onChange={(e) => setData('location_id', e.target.value)} className="w-full border rounded px-2 py-1">
                    <option value="">Chọn vị trí</option>
                    {locations.map(loc => <option key={loc.id} value={loc.id}>{loc.name}</option>)}
                </select>

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
                        {processing ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Tạo mới'}
                    </Button>
                    {isEdit && (
                        <Button type="button" variant="outline" onClick={() => setEditingProperty(null)}>
                            Hủy
                        </Button>
                    )}
                </div>
            </form>

            <div>
                <table className="table-auto w-full mt-4 border border-gray-300">
                    <thead>
                    <tr className="bg-gray-100">
                        <th className="p-2 border">Tên</th>
                        <th className="p-2 border">Giá</th>
                        <th className="p-2 border">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    {properties.map((p) => (
                        <tr key={p.id} className="hover:bg-gray-50">
                            <td className="p-2 border">{p.name}</td>
                            <td className="p-2 border">{p.price}</td>
                            <td className="p-2 border space-x-2">
                                <Button type="button" onClick={() => setEditingProperty(p)}>Sửa</Button>
                                <Button type="button" variant="destructive" onClick={() => handleDelete(p.id)}>Xoá</Button>
                            </td>
                        </tr>
                    ))}
                    {properties.length === 0 && (
                        <tr>
                            <td colSpan={3} className="text-center p-4 text-gray-500">Không có bất động sản nào.</td>
                        </tr>
                    )}
                    </tbody>
                </table>
            </div>
        </div>
    );
}
