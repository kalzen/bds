import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { NewsCategory, Project } from '@/types';
import { useForm } from '@inertiajs/react';
import { useState } from 'react';
import {
    Table,
    TableHeader,
    TableBody,
    TableRow,
    TableHead,
    TableCell,
} from '@/components/ui/table';

interface NewsCategoryFormProps {
    newcategories: NewsCategory[];
    onSave: (category: Partial<NewsCategory>) => void;
    onClose: () => void;
}

interface NewsCategoryFormData {
    name: string;
    description: string | null;
}

export default function NewsCategoryForm({ newcategories , onSave, onClose  }: NewsCategoryFormProps) {
    const [editingNewsCategory, setEditingNewsCategory] = useState<NewsCategory | null>(null);
    const [autoAddress, setAutoAddress] = useState('');
    const [addressDetail, setAddressDetail] = useState('');
    console.log(newcategories)
    const initialFormData: NewsCategoryFormData = {
        name: '',
        description: '',
    };

    const { data, setData, post, put, delete: destroy, processing, errors, reset } = useForm<Partial<NewsCategoryFormData>>(initialFormData);

    const isEdit = Boolean(editingNewsCategory);

    function normalizeFormToNewsCategory(data: Partial<NewsCategoryFormData>): Partial<NewsCategory> {
        return {
            ...data
        };
    }


    const handleDelete = (projectId: number) => {
        if (!confirm('Bạn có chắc chắn muốn xóa dự án này?')) return;

        destroy(route('newcategories.destroy',projectId), {
            onSuccess: () => {
                onSave({}); // Refresh or sync state post-delete
            },
        });
    };

    return (
        <div className="space-y-6 p-4">
            <div className="mt-6">
                <h3 className="text-lg font-bold mb-4">Danh sách danh mục</h3>

                <div className="rounded-md border overflow-auto">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Tên</TableHead>
                                <TableHead>Slug</TableHead>
                                <TableHead>Mô tả</TableHead>
                                <TableHead className="text-right">Thao tác</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {newcategories.length > 0 ? (
                                newcategories.map((category) => (
                                    <TableRow key={category.id}>
                                        <TableCell>{category.name}</TableCell>
                                        <TableCell>{category.slug}</TableCell>
                                        <TableCell>{category.description}</TableCell>
                                        <TableCell className="text-right">
                                            {/*<Button size="sm" onClick={() => handleEdit(category)}>*/}
                                            {/*    Sửa*/}
                                            {/*</Button>*/}
                                            <Button size="sm" variant="destructive" onClick={() => handleDelete(category.id)}>
                                                Xóa
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={9} className="text-center text-muted-foreground py-4">
                                        Không có danh mục.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>
    );
}
