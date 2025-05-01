import { useForm } from '@inertiajs/react';
import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';
import { ListingType } from '@/types';

interface ListingTypeFormProps {
    listingTypes: ListingType[];
}

export default function ListingTypeForm({ listingTypes }: ListingTypeFormProps) {
    const [editingListingType, setEditingListingType] = useState<ListingType | null>(null);
    const [search, setSearch] = useState('');
    const [filteredListingTypes, setFilteredListingTypes] = useState(listingTypes);

    const { data, setData, post, put, delete: destroy, processing, errors, reset } = useForm({
        name: editingListingType?.name || '',
    });

    const isEdit = Boolean(editingListingType);

    useEffect(() => {
        if (editingListingType) {
            setData('name', editingListingType.name);
        } else {
            reset();
        }
    }, [editingListingType]);

    useEffect(() => {
        setFilteredListingTypes(
            listingTypes.filter((type) =>
                type.name.toLowerCase().includes(search.toLowerCase())
            )
        );
    }, [search, listingTypes]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        if (isEdit && editingListingType) {
            put(route('features.listing_types.update', editingListingType.id), {
                onSuccess: () => setEditingListingType(null),
            });
        } else {
            post(route('features.listing_types.store'));
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Bạn có chắc chắn muốn xóa loại danh sách này?')) {
            destroy(route('features.listing_types.destroy', id));
        }
    };

    return (
        <div className="p-4 space-y-6">
            <form onSubmit={handleSubmit} className="space-y-6 max-w-md">
                <div className="grid gap-2">
                    <Input
                        id="name"
                        value={data.name}
                        onChange={(e) => setData('name', e.target.value)}
                        disabled={processing}
                        required
                        placeholder="Nhập tên loại danh sách"
                    />
                    <InputError message={errors.name} className="mt-2" />
                </div>

                <Button type="submit" disabled={processing}>
                    {processing ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Tạo mới'}
                </Button>

                {isEdit && (
                    <Button
                        type="button"
                        variant="outline"
                        className="ml-2"
                        onClick={() => setEditingListingType(null)}
                        disabled={processing}
                    >
                        Hủy chỉnh sửa
                    </Button>
                )}
            </form>

            <div className="mt-8">
                <h2 className="text-lg font-semibold">Danh sách loại danh sách</h2>
                <Input
                    value={search}
                    onChange={(e) => setSearch(e.target.value)}
                    placeholder="Tìm kiếm loại danh sách"
                    className="mb-4"
                />
                <table className="min-w-full mt-4 table-auto">
                    <thead>
                    <tr>
                        <th className="border px-4 py-2">Tên loại danh sách</th>
                        <th className="border px-4 py-2">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    {filteredListingTypes.map((type) => (
                        <tr key={type.id}>
                            <td className="border px-4 py-2">{type.name}</td>
                            <td className="border px-4 py-2">
                                <button
                                    onClick={() => setEditingListingType(type)}
                                    className="text-blue-600"
                                >
                                    Sửa
                                </button>
                                <button
                                    onClick={() => handleDelete(type.id)}
                                    className="ml-2 text-red-600"
                                >
                                    Xóa
                                </button>
                            </td>
                        </tr>
                    ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
}
