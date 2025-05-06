import NewsCategoryForm from '@/components/newcategory/Index';
import AppLayout from '@/layouts/app-layout';
import { NewsCategory } from '@/types';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

const breadcrumbs = [
    {
        title: 'Danh mục tin tức',
        href: '/properties',
    },
];

export default function NewsCategoryManagementPage({ newscategory = [] }: { newscategory: NewsCategory[] }) {
    const [editingNewsCategory, setEditingNewsCategory] = useState<NewsCategory | null>(null);

    const handleSave = (categories: Partial<NewsCategory>) => {
        console.log('NewsCategory saved:', categories);
        setEditingNewsCategory(null);
    };

    const handleClose = () => {
        setEditingNewsCategory(null);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quản lý bất động sản" />

            <div className="flex h-full flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border p-4 md:min-h-min">
                    <NewsCategoryForm newcategories={newscategory} onSave={handleSave} onClose={handleClose} />
                </div>
            </div>
        </AppLayout>
    );
}
