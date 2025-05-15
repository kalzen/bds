import { Button } from '@/components/ui/button';
import { News } from '@/types';
import { router } from '@inertiajs/react';

interface NewsIndexProps {
    news: News[];
    onEdit: (property: News) => void;
    onDelete: (id: number) => void;
    onCreate: () => void;
}
const handleCreate = () => {
    router.visit('/news/create');
};

const handleEdit = (property: News) => {
    router.visit(`/news/${property.id}/edit`);
};

const handleDelete = (id: number) => {
    if (confirm('Bạn có chắc chắn muốn xoá tin tức này?')) {
        router.delete(`/news/${id}`, {
            onSuccess: () => {
                alert('Xoá tin tức thành công!');
                window.location.reload(); // Hoặc cập nhật danh sách tin tức
            },
        });
    }
};

// eslint-disable-next-line @typescript-eslint/no-unused-vars
export default function NewsIndex({ news, onEdit, onDelete, onCreate }: NewsIndexProps) {
    console.log(news)
    return (
        <div className="space-y-6">
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-semibold">🏘️ Tin tức</h1>
                <Button onClick={handleCreate}>+ Tạo mới tin tức</Button>
            </div>

            <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                {news.length > 0 ? (
                    news.map((news) => (
                        <div key={news.id} className="rounded-2xl border bg-white p-4 shadow transition duration-200 hover:shadow-lg">
                            {news.media?.[0]?.original_url && (
                                <img src={news.media[0].original_url} alt={news.title} className="mb-3 h-48 w-full rounded-xl object-cover" />
                            )}
                            <h2 className="text-xl font-bold">Tiêu đề: {news.title}</h2>
                            <p className="mb-2 text-gray-600">{news.slug}</p>

                            <p className="line-clamp-2 text-sm text-gray-500">
                                <strong>  Người đăng: </strong> {news.user?.full_name}
                            </p>

                            <p className="line-clamp-2 text-sm text-gray-500">
                                <strong>  Danh mục: </strong> {news.category?.name}
                            </p>

                            <p className="line-clamp-2 text-sm text-gray-500">
                                <strong>  Mô tả: </strong> {news.description}
                            </p>

                            <div className="mt-4 flex justify-between">
                                <Button size="sm" onClick={() => handleEdit(news)}>
                                    Edit
                                </Button>
                                <Button size="sm" variant="destructive" onClick={() => handleDelete(news.id)}>
                                    Delete
                                </Button>
                            </div>
                        </div>
                    ))
                ) : (
                    <p className="col-span-full text-center text-gray-500">🚫 No news found.</p>
                )}
            </div>
        </div>
    );
}
