import CategoryForm from '@/components/newcategory/CategoryForm';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';

export default function CreateCategory() {
    return (
        <AppLayout>
            <Head title="Thêm danh mục mới" />
            <div className="max-w-xl mx-auto p-1bg-white shadow rounded">
                <h2 className="text-xl font-bold mb-1">Thêm danh mục</h2>
                <CategoryForm
                    method="post"
                    submitUrl={route('categories.store')}
                    onSuccess={() => window.location.href = route('categories.index')}
                />
            </div>
        </AppLayout>
    );
}
