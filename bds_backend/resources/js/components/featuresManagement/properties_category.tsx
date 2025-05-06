import { useState, useEffect, FormEventHandler, ChangeEvent } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Separator } from '@/components/ui/separator';
import InputError from '@/components/input-error';
import { PropertyCategory } from '@/types';
import { Pencil, Trash2 } from 'lucide-react';
import { router } from '@inertiajs/react';

interface PropertiesCategoryFormProps {
    propertyCategories: PropertyCategory[];
}

export default function PropertiesCategoryForm({ propertyCategories }: PropertiesCategoryFormProps) {
    const [editingCategory, setEditingCategory] = useState<PropertyCategory | null>(null);
    const [search, setSearch] = useState('');
    const [form, setForm] = useState({
        name: '',
        icon: null as File | null,
        description: '',
    });
    const [errors, setErrors] = useState<Record<string,string>>({});
    const [processing, setProcessing] = useState(false);

    const isEdit = Boolean(editingCategory);

    useEffect(() => {
        if (editingCategory) {
            setForm({
                name: editingCategory.name,
                icon: null,
                description: editingCategory.description || '',
            });
            setErrors({});
        } else {
            setForm({ name: '', icon: null, description: '' });
            setErrors({});
        }
    }, [editingCategory]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();
        setProcessing(true);

        const formData = new FormData();
        formData.append('name', form.name);
        formData.append('description', form.description);
        if (form.icon) formData.append('icon', form.icon);

        const onFinish = () => setProcessing(false);

        if (isEdit && editingCategory) {
            router.post(
                route('features.property_categories.update', editingCategory.id),
                { _method: 'PUT', ...Object.fromEntries(formData) },
                {
                    forceFormData: true,
                    onSuccess: () => setEditingCategory(null),
                    onError: (err) => setErrors(err),
                    onFinish,
                }
            );
        } else {
            router.post(
                route('features.property_categories.store'),
                formData,
                {
                    forceFormData: true,
                    onError: (err) => setErrors(err),
                    onFinish,
                }
            );
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
            router.delete(route('features.property_categories.destroy', id));
        }
    };

    const filtered = propertyCategories.filter(cat =>
        cat.name.toLowerCase().includes(search.toLowerCase())
    );

    return (
        <Card className="p-4 max-w-4xl mx-auto">
            <CardHeader>
                <CardTitle>{isEdit ? 'Chỉnh sửa danh mục' : 'Thêm danh mục mới'}</CardTitle>
                <CardDescription>Quản lý các danh mục bất động sản</CardDescription>
            </CardHeader>
            <CardContent className="space-y-6">
                {/* Form create/edit */}
                <form onSubmit={handleSubmit} className="grid gap-4 sm:grid-cols-2" encType="multipart/form-data">
                    <div className="space-y-2">
                        <Input
                            value={form.name}
                            onChange={e => setForm({ ...form, name: e.target.value })}
                            disabled={processing}
                            required
                            placeholder="Tên danh mục"
                        />
                        <InputError message={errors.name} />
                    </div>
                    <div className="space-y-2">
                        <Input
                            type="file"
                            accept="image/svg+xml"
                            onChange={(e: ChangeEvent<HTMLInputElement>) =>
                                setForm({ ...form, icon: e.target.files?.[0] || null })
                            }
                            disabled={processing}
                        />
                        <InputError message={errors.icon} />
                    </div>
                    <div className="sm:col-span-2 space-y-2">
                        <Input
                            value={form.description}
                            onChange={e => setForm({ ...form, description: e.target.value })}
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
                                onClick={() => setEditingCategory(null)}
                                disabled={processing}
                            >
                                Hủy
                            </Button>
                        )}
                    </div>
                </form>

                <Separator />

                {/* Search */}
                <div className="max-w-md">
                    <Input
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                        placeholder="Tìm kiếm danh mục..."
                    />
                </div>

                {/* Table */}
                <ScrollArea className="max-h-[400px] rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Icon</TableHead>
                                <TableHead>Tên</TableHead>
                                <TableHead>Mô tả</TableHead>
                                <TableHead className="text-right">Thao tác</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filtered.length > 0 ? (
                                filtered.map(cat => (
                                    <TableRow key={cat.id}>
                                        <TableCell>
                                            {cat.icon_url ? (
                                                <img
                                                    src={cat.icon_url}
                                                    alt="icon"
                                                    className="h-6 w-6 object-contain rounded border"
                                                />
                                            ) : (
                                                <span className="text-sm text-muted-foreground italic">Không có</span>
                                            )}
                                        </TableCell>
                                        <TableCell>{cat.name}</TableCell>
                                        <TableCell>{cat.description}</TableCell>
                                        <TableCell className="text-right space-x-2">
                                            <Button
                                                variant="ghost"
                                                size="icon"
                                                onClick={() => setEditingCategory(cat)}
                                            >
                                                <Pencil className="h-4 w-4" />
                                            </Button>
                                            <Button
                                                variant="destructive"
                                                size="icon"
                                                onClick={() => handleDelete(cat.id)}
                                            >
                                                <Trash2 className="h-4 w-4" />
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={4} className="text-center py-4 text-muted-foreground">
                                        Không tìm thấy danh mục nào.
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
