import { useForm } from '@inertiajs/react';
import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';
import { PropertyCategory } from '@/types';

interface PropertiesCategoryFormProps {
    propertyCategories: PropertyCategory[];
}

export default function PropertiesCategoryForm({ propertyCategories }: PropertiesCategoryFormProps) {
    const [editingCategory, setEditingCategory] = useState<PropertyCategory | null>(null);
    const [search, setSearch] = useState('');
    const [filteredCategories, setFilteredCategories] = useState(propertyCategories);

    const { data, setData, post, put, delete: destroy, processing, errors, reset } = useForm({
        name: editingCategory?.name || '',
    });

    const isEdit = Boolean(editingCategory);

    useEffect(() => {
        if (editingCategory) {
            setData('name', editingCategory.name);
        } else {
            reset();
        }
    }, [editingCategory]);

    useEffect(() => {
        setFilteredCategories(
            propertyCategories.filter((category) =>
                category.name.toLowerCase().includes(search.toLowerCase())
            )
        );
    }, [search, propertyCategories]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        if (isEdit && editingCategory) {
            put(route('features.property_categories.update', editingCategory.id), {
                onSuccess: () => setEditingCategory(null),
            });
        } else {
            post(route('features.property_categories.store'));
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
            destroy(route('features.property_categories.destroy', id));
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
                        placeholder="Nhập tên danh mục"
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
                        onClick={() => setEditingCategory(null)}
                        disabled={processing}
                    >
                        Hủy chỉnh sửa
                    </Button>
                )}
            </form>

            <div className="mt-8">
                <h2 className="text-lg font-semibold">Danh sách danh mục</h2>
                <Input
                    value={search}
                    onChange={(e) => setSearch(e.target.value)}
                    placeholder="Tìm kiếm danh mục"
                    className="mb-4"
                />
                <table className="min-w-full mt-4 table-auto">
                    <thead>
                        <tr>
                            <th className="border px-4 py-2">Tên danh mục</th>
                            <th className="border px-4 py-2">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        {filteredCategories.map((category) => (
                            <tr key={category.id}>
                                <td className="border px-4 py-2">{category.name}</td>
                                <td className="border px-4 py-2">
                                    <button
                                        onClick={() => setEditingCategory(category)}
                                        className="text-blue-600 hover:underline"
                                    >
                                        Sửa
                                    </button>
                                    <button
                                        onClick={() => handleDelete(category.id)}
                                        className="ml-2 text-red-600 hover:underline"
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
