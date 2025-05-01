import { useForm } from '@inertiajs/react';
import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';
import { Attributes } from '@/types';

interface AttributesFormProps {
    attributes: Attributes[];
}

export default function AttributesForm({ attributes }: AttributesFormProps) {
    const [editingAttribute, setEditingAttribute] = useState<Attributes | null>(null);
    const [search, setSearch] = useState('');

    const { data, setData, post, put, delete: destroy, processing, errors, reset } = useForm({
        name: editingAttribute?.name || '',
        data_type: editingAttribute?.data_type || '',
    });

    const isEdit = Boolean(editingAttribute);

    useEffect(() => {
        if (editingAttribute) {
            setData('name', editingAttribute.name);
            setData('data_type', editingAttribute.data_type);
        } else {
            reset();
        }
    }, [editingAttribute]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        if (isEdit && editingAttribute) {
            put(route('features.attributes.update', editingAttribute.id), {
                onSuccess: () => setEditingAttribute(null),
            });
        } else {
            post(route('features.attributes.store'));
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Bạn có chắc chắn muốn xóa thuộc tính này?')) {
            destroy(route('features.attributes.destroy', id));
        }
    };

    const filteredAttributes = attributes.filter((attr) =>
        attr.name.toLowerCase().includes(search.toLowerCase())
    );

    return (
        <div className="p-4 space-y-6">
            {/* Form */}
            <form onSubmit={handleSubmit} className="space-y-6 max-w-md">
                <div className="grid gap-2">
                    <Input
                        id="name"
                        value={data.name}
                        onChange={(e) => setData('name', e.target.value)}
                        disabled={processing}
                        required
                        placeholder="Nhập tên thuộc tính"
                    />
                    <InputError message={errors.name} className="mt-2" />

                    <Input
                        id="data_type"
                        value={data.data_type}
                        onChange={(e) => setData('data_type', e.target.value)}
                        disabled={processing}
                        required
                        placeholder="Nhập kiểu dữ liệu"
                    />
                    <InputError message={errors.data_type} className="mt-2" />
                </div>

                <div className="flex gap-2">
                    <Button type="submit" disabled={processing}>
                        {processing ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Tạo mới'}
                    </Button>

                    {isEdit && (
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => setEditingAttribute(null)}
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
                    placeholder="Tìm kiếm thuộc tính..."
                />
            </div>

            {/* Table */}
            <div className="mt-8">
                <h2 className="text-lg font-semibold">Danh sách thuộc tính</h2>
                <table className="min-w-full mt-4 table-auto">
                    <thead>
                    <tr>
                        <th className="border px-4 py-2">Tên thuộc tính</th>
                        <th className="border px-4 py-2">Kiểu dữ liệu</th>
                        <th className="border px-4 py-2">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    {filteredAttributes.length > 0 ? (
                        filteredAttributes.map((attribute) => (
                            <tr key={attribute.id}>
                                <td className="border px-4 py-2">{attribute.name}</td>
                                <td className="border px-4 py-2">{attribute.data_type}</td>
                                <td className="border px-4 py-2">
                                    <button
                                        onClick={() => setEditingAttribute(attribute)}
                                        className="text-blue-600"
                                    >
                                        Sửa
                                    </button>
                                    <button
                                        onClick={() => handleDelete(attribute.id)}
                                        className="ml-2 text-red-600"
                                    >
                                        Xóa
                                    </button>
                                </td>
                            </tr>
                        ))
                    ) : (
                        <tr>
                            <td colSpan={3} className="text-center py-4">
                                Không tìm thấy thuộc tính nào.
                            </td>
                        </tr>
                    )}
                    </tbody>
                </table>
            </div>
        </div>
    );
}
