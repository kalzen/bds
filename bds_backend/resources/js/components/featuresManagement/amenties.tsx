import { useForm } from '@inertiajs/react';
import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';
import { Amenities } from '@/types';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Table } from '@/components/ui/table';

interface AmenitiesFormProps {
    amenities: Amenities[];
}

export default function AmenitiesForm({ amenities }: AmenitiesFormProps) {
    const [editingAmenity, setEditingAmenity] = useState<Amenities | null>(null);
    const [search, setSearch] = useState('');

    const { data, setData, post, put, delete: destroy, processing, errors, reset } = useForm({
        name: editingAmenity?.name || '',
    });

    const isEdit = Boolean(editingAmenity);

    useEffect(() => {
        if (editingAmenity) {
            setData('name', editingAmenity.name);
        } else {
            reset();
        }
    }, [editingAmenity]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        if (isEdit && editingAmenity) {
            put(route('features.amenities.update', editingAmenity.id), {
                onSuccess: () => setEditingAmenity(null),
            });
        } else {
            post(route('features.amenities.store'));
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Bạn có chắc chắn muốn xóa tiện ích này?')) {
            destroy(route('features.amenities.destroy', id));
        }
    };

    const filteredAmenities = amenities.filter((amenity) =>
        amenity.name.toLowerCase().includes(search.toLowerCase())
    );

    return (
        <div className="p-4 space-y-6">
            {/* Form to add or edit amenities */}
            <form onSubmit={handleSubmit} className="space-y-6 max-w-md">
                <div className="grid gap-2">
                    <Input
                        id="name"
                        value={data.name}
                        onChange={(e) => setData('name', e.target.value)}
                        disabled={processing}
                        required
                        placeholder="Nhập tên tiện ích"
                    />
                    <InputError message={errors.name} className="mt-2" />
                </div>

                <div className="flex gap-2">
                    <Button type="submit" disabled={processing}>
                        {processing ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Tạo mới'}
                    </Button>

                    {isEdit && (
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => setEditingAmenity(null)}
                            disabled={processing}
                        >
                            Hủy chỉnh sửa
                        </Button>
                    )}
                </div>
            </form>

            {/* Search input */}
            <div className="max-w-md">
                <Input
                    type="text"
                    value={search}
                    onChange={(e) => setSearch(e.target.value)}
                    placeholder="Tìm kiếm tiện ích..."
                />
            </div>

            {/* Table to display amenities */}
            <div className="mt-8">
                <h2 className="text-lg font-semibold">Danh sách tiện ích</h2>
                <ScrollArea className="max-w-full mt-4">
                    <Table className="min-w-full">
                        <thead>
                        <tr>
                            <th className="border px-4 py-2">Tên tiện ích</th>
                            <th className="border px-4 py-2">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        {filteredAmenities.length > 0 ? (
                            filteredAmenities.map((amenity) => (
                                <tr key={amenity.id}>
                                    <td className="border px-4 py-2">{amenity.name}</td>
                                    <td className="border px-4 py-2">
                                        <button
                                            onClick={() => setEditingAmenity(amenity)}
                                            className="text-blue-600 hover:text-blue-800"
                                        >
                                            Sửa
                                        </button>
                                        <button
                                            onClick={() => handleDelete(amenity.id)}
                                            className="ml-2 text-red-600 hover:text-red-800"
                                        >
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan={2} className="text-center py-4">
                                    Không tìm thấy tiện ích nào.
                                </td>
                            </tr>
                        )}
                        </tbody>
                    </Table>
                </ScrollArea>
            </div>
        </div>
    );
}
