import { useForm } from '@inertiajs/react';
import { useEffect, useState, FormEventHandler } from 'react';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';
import type { News, NewsCategory } from '@/types';

interface NewsFormProps {
    news?: News;
    categories: { id: number; name: string }[];
    currentUserId: number;
}

interface NewsFormData {
    [key: string]: string | number | File | null;
    title: string;
    slug: string;
    description: string;
    content: string;
    publish_date: string;
    category_id: number | string;
    image: File | null;
    user_id: number;
}

export default function NewsForm({ news, categories, currentUserId }: NewsFormProps) {
    console.log(categories);
    const isEdit = Boolean(news);
    const [editingNews, setEditingNews] = useState<News | null>(null);

    const initialData: NewsFormData = {
        title: '',
        slug: '',
        description: '',
        content: '',
        publish_date: '',
        category_id: '',
        image: null,
        user_id: currentUserId,
    };

    const { data, setData, post, reset, errors, processing, transform } = useForm<NewsFormData>(initialData);

    useEffect(() => {
        if (news) {
            setEditingNews(news);
            setData({
                title: news.title,
                slug: news.slug,
                description: news.description,
                content: news.content,
                publish_date: news.publish_date,
                category_id: news.category_id || '',
                image: null,
                user_id: parseInt(news.user_id),
            });
        }
    }, [news]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        const formData = new FormData();
        transform((formDataObj) => {
            Object.entries(formDataObj).forEach(([key, value]) => {
                if (key === 'image' && value instanceof File) {
                    formData.append('image', value);
                } else {
                    formData.append(key, value as string);
                }
            });
            return formData;
        });
        console.log(data)
        post(
            isEdit && editingNews
                ? route('news.update', editingNews.id)
                : route('news.store'),
            {
                forceFormData: true,
                onSuccess: () => {
                    if (isEdit) setEditingNews(null);
                    reset();
                },
            }
        );
    };

    return (

        <form onSubmit={handleSubmit} className="space-y-6 max-w-2xl mx-auto p-6 bg-white rounded-xl shadow">
            <h2 className="text-xl font-semibold text-gray-800">{isEdit ? 'Cập nhật tin tức' : 'Thêm tin tức mới'}</h2>

            <div>
                <label className="block font-medium mb-1">Tiêu đề</label>
                <Input value={data.title} onChange={(e) => setData('title', e.target.value)} />
                <InputError message={errors.title} />
            </div>

            <div>
                <label className="block font-medium mb-1">Slug</label>
                <Input value={data.slug} onChange={(e) => setData('slug', e.target.value)} />
                <InputError message={errors.slug} />
            </div>

            <div>
                <label className="block font-medium mb-1">Mô tả</label>
                <Textarea rows={3} value={data.description} onChange={(e) => setData('description', e.target.value)} />
                <InputError message={errors.description} />
            </div>

            <div>
                <label className="block font-medium mb-1">Nội dung</label>
                <Textarea rows={6} value={data.content} onChange={(e) => setData('content', e.target.value)} />
                <InputError message={errors.content} />
            </div>

            <div>
                <label className="block font-medium mb-1">Ngày đăng</label>
                <Input type="date" value={data.publish_date} onChange={(e) => setData('publish_date', e.target.value)} />
                <InputError message={errors.publish_date} />
            </div>

            <div>
                <label className="block font-medium mb-1">Danh mục</label>
                <select
                    className="w-full rounded border px-3 py-2"
                    value={data.category_id}
                    onChange={(e) => setData('category_id', e.target.value)}
                >
                    <option value="">Chọn danh mục</option>
                    {categories.map((cat) => (
                        <option key={cat.id} value={cat.id}>
                            {cat.name}
                        </option>
                    ))}
                </select>
                <InputError message={errors.category_id} />
            </div>

            <div>
                <label className="block font-medium mb-1">Ảnh đại diện</label>
                <input type="file" accept="image/*" onChange={(e) => setData('image', e.target.files?.[0] || null)} />
                <InputError message={errors.image} />
            </div>

            <Button type="submit" disabled={processing}>
                {processing ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Thêm mới'}
            </Button>
        </form>
    );
}
