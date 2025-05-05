import { useForm } from '@inertiajs/react';
import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';
import { PropertyCategory } from '@/types';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { ScrollArea } from '@/components/ui/scroll-area';
import {
    Table,
    TableHeader,
    TableBody,
    TableRow,
    TableHead,
    TableCell,
} from '@/components/ui/table';

interface PropertiesCategoryFormProps {
    propertyCategories: PropertyCategory[];
}

export default function PropertiesCategoryForm({ propertyCategories }: PropertiesCategoryFormProps) {
    const [editingCategory, setEditingCategory] = useState<PropertyCategory | null>(null);
    const [search, setSearch] = useState('');

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

    const filteredCategories = propertyCategories.filter((category) =>
        category.name.toLowerCase().includes(search.toLowerCase())
    );

    return (
        <Card className="max-w-4xl mx-auto">
            <CardHeader>
                <CardTitle>Quản lý danh mục</CardTitle>
                <CardDescription>Thêm, chỉnh sửa hoặc xóa danh mục bất động sản</CardDescription>
            </CardHeader>

            <CardContent className="space-y-6">
                {/* Form */}
                <form onSubmit={handleSubmit} className="space-y-4 max-w-md">
                    <div>
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

                    <div className="flex gap-2">
                        <Button type="submit" disabled={processing}>
                            {processing ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Tạo mới'}
                        </Button>
                        {isEdit && (
                            <Button
                                type="button"
                                variant="outline"
                                onClick={() => setEditingCategory(null)}
                                disabled={processing}
                            >
                                Hủy chỉnh sửa
                            </Button>
                        )}
                    </div>
                </form>

                {/* Search */}
                <div className="max-w-md">
                    <Input
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        placeholder="Tìm kiếm danh mục"
                    />
                </div>

                {/* Danh sách danh mục */}
                <ScrollArea className="rounded-md border max-h-[400px]">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-1/2">Tên danh mục</TableHead>
                                <TableHead className="text-right">Thao tác</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredCategories.length > 0 ? (
                                filteredCategories.map((category) => (
                                    <TableRow key={category.id}>
                                        <TableCell>{category.name}</TableCell>
                                        <TableCell className="text-right space-x-2">
                                            <Button
                                                variant="ghost"
                                                size="sm"
                                                onClick={() => setEditingCategory(category)}
                                            >
                                                Sửa
                                            </Button>
                                            <Button
                                                variant="destructive"
                                                size="sm"
                                                onClick={() => handleDelete(category.id)}
                                            >
                                                Xóa
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={2} className="text-center text-muted-foreground py-6">
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
