import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/components/ui/table';
import { Separator } from '@/components/ui/separator';
import InputError from '@/components/input-error';
import { Pencil, Trash2 } from 'lucide-react';
import { router } from '@inertiajs/react';
import { ListingType } from '@/types';

interface ListingTypeFormProps {
    listingTypes: ListingType[];
}

export default function ListingTypeForm({ listingTypes }: ListingTypeFormProps) {
    const [editingListingType, setEditingListingType] = useState<ListingType | null>(null);
    const [search, setSearch] = useState('');
    const [form, setForm] = useState({
        name: '',
        icon: null as File | null,
        description: '',
    });
    const [errors, setErrors] = useState<Record<string, string>>({});
    const [processing, setProcessing] = useState(false);

    const isEdit = Boolean(editingListingType);

    useEffect(() => {
        if (editingListingType) {
            setForm({
                name: editingListingType.name,
                icon: null, // reset file input
                description: editingListingType.description || '',
            });
        } else {
            setForm({ name: '', icon: null, description: '' });
            setErrors({});
        }
    }, [editingListingType]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();
        setProcessing(true);

        const formData = new FormData();
        formData.append('name', form.name);
        formData.append('description', form.description);
        if (form.icon) formData.append('icon', form.icon);

        const onFinish = () => setProcessing(false);

        console.log(form)
        if (isEdit && editingListingType) {
            router.post(
                route('features.listing_types.update', editingListingType.id),
                { _method: 'PUT', ...Object.fromEntries(formData) },
                {
                    forceFormData: true,
                    onSuccess: () => setEditingListingType(null),
                    onError: (e) => setErrors(e),
                    onFinish,
                }
            );
        } else {
            router.post(route('features.listing_types.store'), formData, {
                forceFormData: true,
                onError: (e) => setErrors(e),
                onFinish,
            });
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Bạn có chắc chắn muốn xóa loại danh sách này?')) {
            router.delete(route('features.listing_types.destroy', id));
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
                {/* Form */}
                <form onSubmit={handleSubmit} className="grid gap-4 sm:grid-cols-2" encType="multipart/form-data">
                    <div className="space-y-2">
                        <Input
                            value={form.name}
                            onChange={(e) => setForm({ ...form, name: e.target.value })}
                            disabled={processing}
                            required
                            placeholder="Tên loại danh sách"
                        />
                        <InputError message={errors.name} />
                    </div>
                    <div className="space-y-2">
                        <Input
                            type="file"
                            accept=".svg"
                            onChange={(e) => {
                                const file = e.target.files?.[0] ?? null;
                                setForm({ ...form, icon: file });
                            }}
                            disabled={processing}
                        />
                        <InputError message={errors.icon} />
                    </div>
                    <div className="space-y-2 sm:col-span-2">
                        <Input
                            value={form.description}
                            onChange={(e) => setForm({ ...form, description: e.target.value })}
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
                                onClick={() => setEditingListingType(null)}
                                disabled={processing}
                            >
                                Hủy
                            </Button>
                        )}
                    </div>
                </form>

                <Separator />

                {/* Search */}
                <div className="max-w-sm">
                    <Input
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        placeholder="Tìm kiếm loại danh sách..."
                    />
                </div>

                {/* Table */}
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
                                        <TableCell>
                                            {type.icon_url ? (
                                                <img
                                                    src={type.icon_url}
                                                    alt="Icon"
                                                    className="h-6 w-6 object-contain rounded border"
                                                />
                                            ) : (
                                                <span className="text-sm text-muted-foreground italic">Không có</span>
                                            )}
                                        </TableCell>
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
