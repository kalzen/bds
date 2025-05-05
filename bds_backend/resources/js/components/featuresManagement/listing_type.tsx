import { useForm } from '@inertiajs/react';
import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/components/ui/table';
import { Pencil, Trash2 } from 'lucide-react';
import InputError from '@/components/input-error';
import { ListingType } from '@/types';

interface ListingTypeFormProps {
    listingTypes: ListingType[];
}

export default function ListingTypeForm({ listingTypes }: ListingTypeFormProps) {
    const [editingListingType, setEditingListingType] = useState<ListingType | null>(null);
    const [search, setSearch] = useState('');

    const { data, setData, post, put, delete: destroy, processing, errors, reset } = useForm({
        name: editingListingType?.name || '',
        icon: editingListingType?.icon || '',
        description: editingListingType?.description || '',
    });

    const isEdit = Boolean(editingListingType);

    useEffect(() => {
        if (editingListingType) {
            setData({
                name: editingListingType.name,
                icon: editingListingType.icon || '',
                description: editingListingType.description || '',
            });
        } else {
            reset();
        }
    }, [editingListingType]);

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

    const filteredTypes = listingTypes.filter((type) =>
        type.name.toLowerCase().includes(search.toLowerCase())
    );

    return (
        <Card className="p-4 max-w-4xl mx-auto">
            <CardHeader>
                <CardTitle>{isEdit ? 'Chỉnh sửa loại danh sách' : 'Thêm loại danh sách mới'}</CardTitle>
                <CardDescription>Quản lý các loại danh sách bất động sản</CardDescription>
            </CardHeader>

            <CardContent className="space-y-6">
                <form onSubmit={handleSubmit} className="grid gap-4 sm:grid-cols-2">
                    <div className="space-y-2">
                        <Input
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            disabled={processing}
                            required
                            placeholder="Tên loại danh sách"
                        />
                        <InputError message={errors.name} />
                    </div>
                    <div className="space-y-2">
                        <Input
                            value={data.icon}
                            onChange={(e) => setData('icon', e.target.value)}
                            disabled={processing}
                            placeholder="Tên icon (ví dụ: home, building)"
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
                            <Button type="button" variant="ghost" onClick={() => setEditingListingType(null)} disabled={processing}>
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
                        placeholder="Tìm kiếm loại danh sách..."
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
                            {filteredTypes.length > 0 ? (
                                filteredTypes.map((type) => (
                                    <TableRow key={type.id}>
                                        <TableCell>{type.name}</TableCell>
                                        <TableCell>{type.icon}</TableCell>
                                        <TableCell>{type.description}</TableCell>
                                        <TableCell className="text-right space-x-2">
                                            <Button
                                                variant="outline"
                                                size="icon"
                                                onClick={() => setEditingListingType(type)}
                                            >
                                                <Pencil className="w-4 h-4" />
                                            </Button>
                                            <Button
                                                variant="destructive"
                                                size="icon"
                                                onClick={() => handleDelete(type.id)}
                                            >
                                                <Trash2 className="w-4 h-4" />
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={4} className="text-center py-6 text-muted-foreground">
                                        Không tìm thấy loại danh sách nào.
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
