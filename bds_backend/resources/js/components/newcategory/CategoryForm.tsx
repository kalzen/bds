import React, { FormEvent } from 'react';
import { useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import InputError from '@/components/input-error';
import { NewsCategory } from '@/types';

interface Props {
    initialData?: Partial<NewsCategory>;
    onSuccess: () => void;
    submitUrl: string;
    method: 'post' | 'put';
}

export default function CategoryForm({ initialData = {}, onSuccess, submitUrl, method }: Props) {
    const { data, setData, post, put, processing, errors, reset } = useForm<Partial<NewsCategory>>({
        name: initialData.name || '',
        description: initialData.description || '',
        slug: initialData.slug || '',
    });

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        const action = method === 'post' ? post : put;

        action(submitUrl, {
            onSuccess: () => {
                reset();
                onSuccess();
            },
        });
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-4">
            <div>
                <label htmlFor="name" className="block font-medium">Tên danh mục</label>
                <Input id="name" value={data.name ?? ''} onChange={e => setData('name', e.target.value)} />
                <InputError message={errors.name} />
            </div>
            <div>
                <label htmlFor="name" className="block font-medium">Slug</label>
                <Input id="name" value={data.slug ?? ''} onChange={e => setData('slug', e.target.value)} />
                <InputError message={errors.slug} />
            </div>

            <div>
                <label htmlFor="description" className="block font-medium">Mô tả</label>
                <textarea
                    id="description"
                    value={data.description ?? ''}
                    onChange={e => setData('description', e.target.value)}
                    className="w-full border rounded-md"
                    rows={3}
                />
                <InputError message={errors.description} />
            </div>

            <Button type="submit" disabled={processing}>
                {method === 'post' ? 'Tạo mới' : 'Cập nhật'}
            </Button>
        </form>
    );
}
