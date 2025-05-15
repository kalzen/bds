import NewsForm from '@/components/news/Form';
import AppLayout from '@/layouts/app-layout';
import { News } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs = [
    {
        title: 'Tin tức',
        href: '/news',
    },
];
console.log('management');
export default function PropertyManagementPage({
    news,
    news1 = [],
    categories,
    auth,
}: {
    news?: News;
    news1: News[];
    categories: { id: number; name: string }[];
    auth: {
        user: {
            id: number;
            name: string;
        };
    };
}) {
    console.log('news', categories);
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quản lý tin tức" />

            <div className="flex h-full flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border p-4 md:min-h-min">
                    <NewsForm
                        news={news} // 👈 Thêm prop này
                        categories={categories}
                        currentUserId={auth.user.id}
                    />
                </div>
            </div>
        </AppLayout>
    );
}
