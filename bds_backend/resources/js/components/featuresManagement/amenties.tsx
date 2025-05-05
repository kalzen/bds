import { useForm } from '@inertiajs/react';
import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';
import { Amenities } from '@/types';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/components/ui/table';
import { Pencil, Trash2 } from 'lucide-react';

interface AmenitiesFormProps {
    amenities: Amenities[];
}

export default function AmenitiesForm({ amenities }: AmenitiesFormProps) {
    const [editingAmenity, setEditingAmenity] = useState<Amenities | null>(null);
    const [search, setSearch] = useState('');

    const { data, setData, post, put, delete: destroy, processing, errors, reset } = useForm({
        name: editingAmenity?.name || '',
        icon: editingAmenity?.icon || '',
        description: editingAmenity?.description || '',
    });

    const isEdit = Boolean(editingAmenity);

    useEffect(() => {
        if (editingAmenity) {
            setData({
                name: editingAmenity.name,
                icon: editingAmenity.icon || '',
                description: editingAmenity.description || '',
            });
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
        <Card className="p-4 max-w-4xl mx-auto">
            <CardHeader>
                <CardTitle>{isEdit ? 'Chỉnh sửa tiện ích' : 'Thêm tiện ích mới'}</CardTitle>
                <CardDescription>Quản lý các tiện ích của bất động sản</CardDescription>
            </CardHeader>

            <CardContent className="space-y-6">
                <form onSubmit={handleSubmit} className="grid gap-4 sm:grid-cols-2">
                    <div className="space-y-2">
                        <Input
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            disabled={processing}
                            required
                            placeholder="Tên tiện ích"
                        />
                        <InputError message={errors.name} />
                    </div>

                    <div className="space-y-2">
                        <Input
                            value={data.icon}
                            onChange={(e) => setData('icon', e.target.value)}
                            disabled={processing}
                            placeholder="Tên icon (ví dụ: wifi, parking)"
                        />
                        <InputError message={errors.icon} />
                    </div>

                    <div className="sm:col-span-2 space-y-2">
                        <Input
                            value={data.description}
                            onChange={(e) => setData('description', e.target.value)}
                            disabled={processing}
                            placeholder="Mô tả (tùy chọn)"
                        />
                        <InputError message={errors.description} />
                    </div>

                    <div className="col-span-2 flex gap-2">
                        <Button type="submit" disabled={processing}>
                            {processing ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Tạo mới'}
                        </Button>
                        {isEdit && (
                            <Button
                                type="button"
                                variant="ghost"
                                onClick={() => setEditingAmenity(null)}
                                disabled={processing}
                            >
                                Hủy
                            </Button>
                        )}
                    </div>
                </form>

                <div className="max-w-md">
                    <Input
                        type="text"
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        placeholder="Tìm kiếm tiện ích..."
                    />
                </div>

                <ScrollArea className="rounded-md border max-h-[400px]">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Tên</TableHead>
                                <TableHead>Icon</TableHead>
                                <TableHead>Mô tả</TableHead>
                                <TableHead className="text-right">Thao tác</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredAmenities.length > 0 ? (
                                filteredAmenities.map((amenity) => (
                                    <TableRow key={amenity.id}>
                                        <TableCell>{amenity.name}</TableCell>
                                        <TableCell>{amenity.icon}</TableCell>
                                        <TableCell>{amenity.description}</TableCell>
                                        <TableCell className="text-right space-x-2">
                                            <Button
                                                variant="outline"
                                                size="icon"
                                                onClick={() => setEditingAmenity(amenity)}
                                            >
                                                <Pencil className="w-4 h-4" />
                                            </Button>
                                            <Button
                                                variant="destructive"
                                                size="icon"
                                                onClick={() => handleDelete(amenity.id)}
                                            >
                                                <Trash2 className="w-4 h-4" />
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={4} className="text-center py-6 text-muted-foreground">
                                        Không tìm thấy tiện ích nào.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </ScrollArea>
            </CardContent>
        </Card>
    );
}
