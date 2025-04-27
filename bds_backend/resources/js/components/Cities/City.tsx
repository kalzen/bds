import { useForm } from '@inertiajs/react';
import { FormEventHandler, useState, useEffect } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';

interface CityFormProps {
    city?: {
        id: number;
        name: string;
    };
    cities: {
        id: number; name: string
    }[];
}

export default function CityForm({ city, cities }: CityFormProps) {
    const [editingCity, setEditingCity] = useState(city || null);

    const { data, setData, post, put, delete: destroy, processing, errors, reset } = useForm({
        name: editingCity?.name || '',
    });

    const isEdit = Boolean(editingCity);

    useEffect(() => {
        if (editingCity) {
            setData('name', editingCity.name);
        } else {
            reset();
        }
    }, [editingCity]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        if (isEdit && editingCity) {
            put(route('location.cities.update', editingCity.id), {
                onSuccess: () => {
                    setEditingCity(null); // reset edit state after update
                },
            });
        } else {
            post(route('location.cities.store'));
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Bạn có chắc chắn muốn xoá thành phố này?')) {
            destroy(route('location.cities.destroy', id));
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
                        placeholder="Nhập tên thành phố"
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
                        onClick={() => setEditingCity(null)}
                        disabled={processing}
                    >
                        Hủy chỉnh sửa
                    </Button>
                )}
            </form>

            <div className="mt-8">
                <h2 className="text-lg font-semibold">Danh sách thành phố</h2>
                <table className="min-w-full mt-4 table-auto">
                    <thead>
                    <tr>
                        <th className="border px-4 py-2">Tên thành phố</th>
                        <th className="border px-4 py-2">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    {cities.map((cityItem) => (
                        <tr key={cityItem.id}>
                            <td className="border px-4 py-2">{cityItem.name}</td>
                            <td className="border px-4 py-2">
                                <button
                                    onClick={() => setEditingCity(cityItem)}
                                    className="text-blue-600 hover:underline"
                                >
                                    Sửa
                                </button>
                                <button
                                    onClick={() => handleDelete(cityItem.id)}
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
