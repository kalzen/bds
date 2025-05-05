import { useState, useEffect, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Separator } from '@/components/ui/separator';
import InputError from '@/components/input-error';
import { Attribute } from '@/types';
import { Pencil, Trash2 } from 'lucide-react';
import { router } from '@inertiajs/react';

interface AttributesFormProps {
    attributes: Attribute[];
}

export default function AttributesForm({ attributes }: AttributesFormProps) {
    const [editingAttribute, setEditingAttribute] = useState<Attribute | null>(null);
    const [search, setSearch] = useState('');
    const [form, setForm] = useState({
        name: '',
        data_type: '',
        icon: null as File | null,
        description: '',
    });
    const [errors, setErrors] = useState<Record<string, string>>({});
    const [processing, setProcessing] = useState(false);

    const isEdit = Boolean(editingAttribute);

    console.log(attributes)
    useEffect(() => {
        if (editingAttribute) {
            setForm({
                name: editingAttribute.name,
                data_type: editingAttribute.data_type,
                icon: null,
                description: editingAttribute.description ?? '',
            });
        } else {
            setForm({ name: '', data_type: '', icon: null, description: '' });
            setErrors({});
        }
    }, [editingAttribute]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();
        setProcessing(true);

        const formData = new FormData();
        formData.append('name', form.name);
        formData.append('data_type', form.data_type);
        formData.append('description', form.description);
        if (form.icon) formData.append('icon', form.icon);

        console.log(form)

        const onFinish = () => setProcessing(false);

        if (isEdit && editingAttribute) {
            router.post(
                route('features.attributes.update', editingAttribute.id),
                { _method: 'PUT', ...Object.fromEntries(formData) },
                {
                    forceFormData: true,
                    onSuccess: () => setEditingAttribute(null),
                    onError: (e) => setErrors(e),
                    onFinish,
                }
            );
        } else {
            router.post(route('features.attributes.store'), formData, {
                forceFormData: true,
                onError: (e) => setErrors(e),
                onFinish,
            });
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Bạn có chắc chắn muốn xóa thuộc tính này?')) {
            router.delete(route('features.attributes.destroy', id));
        }
    };

    const filteredAttributes = attributes.filter((attr) =>
        attr.name.toLowerCase().includes(search.toLowerCase())
    );

    return (
        <Card className="p-4">
            <h1>Attribute</h1>
            <CardHeader>
                <CardTitle>{isEdit ? 'Chỉnh sửa thuộc tính' : 'Thêm thuộc tính mới'}</CardTitle>
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
                            placeholder="Tên thuộc tính"
                        />
                        <InputError message={errors.name} />
                    </div>
                    <div className="space-y-2">
                        <Input
                            value={form.data_type}
                            onChange={(e) => setForm({ ...form, data_type: e.target.value })}
                            disabled={processing}
                            required
                            placeholder="Kiểu dữ liệu (string, number, etc)"
                        />
                        <InputError message={errors.data_type} />
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
                    <div className="space-y-2">
                        <Input
                            value={form.description}
                            onChange={(e) => setForm({ ...form, description: e.target.value })}
                            disabled={processing}
                            placeholder="Mô tả"
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
                                onClick={() => setEditingAttribute(null)}
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
                        placeholder="Tìm kiếm thuộc tính..."
                    />
                </div>

                {/* Table */}
                <ScrollArea className="max-h-[400px]">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Icon</TableHead>
                                <TableHead>Tên</TableHead>
                                <TableHead>Kiểu dữ liệu</TableHead>
                                <TableHead>Mô tả</TableHead>
                                <TableHead className="text-right">Thao tác</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {filteredAttributes.length > 0 ? (
                                filteredAttributes.map((attribute) => (
                                    <TableRow key={attribute.id}>
                                        <TableCell>
                                            {attribute.icon_url ? (
                                                <img
                                                    src={attribute.icon_url}
                                                    alt="Icon"
                                                    className="h-6 w-6 object-contain rounded border"
                                                />
                                            ) : (
                                                <span className="text-sm text-muted-foreground italic">Không có</span>
                                            )}
                                        </TableCell>

                                        <TableCell>{attribute.name}</TableCell>
                                        <TableCell>{attribute.data_type}</TableCell>
                                        <TableCell>{attribute.description}</TableCell>

                                        <TableCell className="text-right space-x-2">
                                            <Button variant="outline" size="icon" onClick={() => setEditingAttribute(attribute)}>
                                                <Pencil className="h-4 w-4" />
                                            </Button>
                                            <Button variant="destructive" size="icon" onClick={() => handleDelete(attribute.id)}>
                                                <Trash2 className="h-4 w-4" />
                                            </Button>
                                        </TableCell>
                                    </TableRow>

                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={4} className="text-center text-muted-foreground py-4">
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
