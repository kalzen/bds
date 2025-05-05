import { useForm } from '@inertiajs/react';
import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Separator } from '@/components/ui/separator';
import InputError from '@/components/input-error';
import { Attributes } from '@/types';
import { Pencil, Trash2 } from 'lucide-react';

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
        <Card className="p-4">
            <CardHeader>
                <CardTitle>{isEdit ? 'Chỉnh sửa thuộc tính' : 'Thêm thuộc tính mới'}</CardTitle>
            </CardHeader>
            <CardContent className="space-y-6">
                {/* Form */}
                <form onSubmit={handleSubmit} className="grid gap-4 sm:grid-cols-2">
                    <div className="space-y-2">
                        <Input
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            disabled={processing}
                            required
                            placeholder="Tên thuộc tính"
                        />
                        <InputError message={errors.name} className="text-sm text-red-500" />
                    </div>
                    <div className="space-y-2">
                        <Input
                            value={data.data_type}
                            onChange={(e) => setData('data_type', e.target.value)}
                            disabled={processing}
                            required
                            placeholder="Kiểu dữ liệu (ví dụ: string, number)"
                        />
                        <InputError message={errors.data_type} className="text-sm text-red-500" />
                    </div>

                    <div className="col-span-2 flex gap-2">
                        <Button type="submit" disabled={processing}>
                            {processing ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Tạo mới'}
                        </Button>
                        {isEdit && (
                            <Button type="button" variant="ghost" onClick={() => setEditingAttribute(null)} disabled={processing}>
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
                        placeholder="Tìm kiếm thuộc tính..."
                    />
                </div>

                {/* Table */}
                <ScrollArea className="max-h-[400px]">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Tên</TableHead>
                                <TableHead>Kiểu dữ liệu</TableHead>
                                <TableHead className="text-right">Thao tác</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredAttributes.length > 0 ? (
                                filteredAttributes.map((attribute) => (
                                    <TableRow key={attribute.id}>
                                        <TableCell>{attribute.name}</TableCell>
                                        <TableCell>{attribute.data_type}</TableCell>
                                        <TableCell className="text-right space-x-2">
                                            <Button
                                                variant="outline"
                                                size="icon"
                                                onClick={() => setEditingAttribute(attribute)}
                                            >
                                                <Pencil className="h-4 w-4" />
                                            </Button>
                                            <Button
                                                variant="destructive"
                                                size="icon"
                                                onClick={() => handleDelete(attribute.id)}
                                            >
                                                <Trash2 className="h-4 w-4" />
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={3} className="text-center text-muted-foreground py-4">
                                        Không tìm thấy thuộc tính nào.
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
