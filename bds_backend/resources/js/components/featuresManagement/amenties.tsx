import { useState, useEffect, FormEventHandler, ChangeEvent } from 'react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Separator } from '@/components/ui/separator';
import InputError from '@/components/input-error';
import { Amenity } from '@/types';
import { Pencil, Trash2 } from 'lucide-react';
import { router } from '@inertiajs/react';

interface AmenitiesFormProps {
    amenities: Amenity[];
}

export default function AmenitiesForm({ amenities }: AmenitiesFormProps) {
    const [editingAmenity, setEditingAmenity] = useState<Amenity | null>(null);
    const [search, setSearch] = useState('');
    const [form, setForm] = useState({
        name: '',
        icon: null as File | null,
        description: '',
    });
    const [errors, setErrors] = useState<Record<string, string>>({});
    const [processing, setProcessing] = useState(false);

    const isEdit = Boolean(editingAmenity);
    console.log(amenities)
    useEffect(() => {
        if (editingAmenity) {
            setForm({
                name: editingAmenity.name,
                icon: null,
                description: editingAmenity.description ?? '',
            });
        } else {
            setForm({ name: '', icon: null, description: '' });
            setErrors({});
        }
    }, [editingAmenity]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();
        setProcessing(true);

        const formData = new FormData();
        formData.append('name', form.name);
        formData.append('description', form.description);
        if (form.icon) formData.append('icon', form.icon);

        const onFinish = () => setProcessing(false);

        if (isEdit && editingAmenity) {
            router.post(
                route('features.amenities.update', editingAmenity.id),
                { _method: 'PUT', ...Object.fromEntries(formData) },
                {
                    forceFormData: true,
                    onSuccess: () => setEditingAmenity(null),
                    onError: (e) => setErrors(e),
                    onFinish,
                }
            );
        } else {
            router.post(route('features.amenities.store'), formData, {
                forceFormData: true,
                onError: (e) => setErrors(e),
                onFinish,
            });
        }
    };

    const handleDelete = (id: number) => {
        if (confirm('Bạn có chắc chắn muốn xóa tiện ích này?')) {
            router.delete(route('features.amenities.destroy', id));
        }
    };

    const filteredAmenities = amenities.filter((amenity) =>
        amenity.name.toLowerCase().includes(search.toLowerCase())
    );

    return (
        <Card className="p-4">
            <h1>Amenities</h1>
            <CardHeader>
                <CardTitle>{isEdit ? 'Chỉnh sửa tiện ích' : 'Thêm tiện ích mới'}</CardTitle>
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
                            placeholder="Tên tiện ích"
                        />
                        <InputError message={errors.name} />
                    </div>
                    <div className="space-y-2">
                        <Input
                            type="file"
                            accept=".svg"
                            onChange={(e: ChangeEvent<HTMLInputElement>) => {
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
                                onClick={() => setEditingAmenity(null)}
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
                        placeholder="Tìm kiếm tiện ích..."
                    />
                </div>

                {/* Table */}
                <ScrollArea className="max-h-[400px]">
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
                            {filteredAmenities.length > 0 ? (
                                filteredAmenities.map((amenity) => (
                                    <TableRow key={amenity.id}>
                                        <TableCell>
                                            {amenity.icon_url ? (
                                                <img
                                                    src={amenity.icon_url}
                                                    alt="Icon"
                                                    className="h-6 w-6 object-contain rounded border"
                                                />
                                            ) : (
                                                <span className="text-sm text-muted-foreground italic">Không có</span>
                                            )}
                                        </TableCell>
                                        <TableCell>{amenity.name}</TableCell>
                                        <TableCell>{amenity.description}</TableCell>
                                        <TableCell className="text-right space-x-2">
                                            <Button variant="outline" size="icon" onClick={() => setEditingAmenity(amenity)}>
                                                <Pencil className="h-4 w-4" />
                                            </Button>
                                            <Button variant="destructive" size="icon" onClick={() => handleDelete(amenity.id)}>
                                                <Trash2 className="h-4 w-4" />
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={4} className="text-center text-muted-foreground py-4">
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
