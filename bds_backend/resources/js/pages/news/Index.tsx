import { Button } from '@/components/ui/button';
import { News } from '@/types';
import NewsList from '@/components/news/Index'; // ✅ Renamed to avoid conflict
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';

const breadcrumbs = [
    {
        title: 'Bất động sản',
        href: '/properties',
    },
];

interface NewsIndexProps {
    news: News[];
    onEdit: (news: News) => void;
    onDelete: (id: number) => void;
    onCreate: () => void;
}

export default function NewsIndexPage({ news, onEdit, onDelete, onCreate }: NewsIndexProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quản lý tin tức" />
            <div className="flex h-full flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border p-4 md:min-h-min">
                    <NewsList
                        news={news}
                        onEdit={onEdit}
                        onDelete={onDelete}
                        onCreate={onCreate}
                    />
                </div>
            </div>
        </AppLayout>
    );
}
