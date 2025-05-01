
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Trang chủ',
        href: '/dashboard',
    },
];


export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Trang chủ" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min p-4">
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {/* Thống kê tổng quan */}
                        <div className="col-span-1 md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                                <h3 className="text-sm font-medium text-gray-500">Tổng bất động sản</h3>
                                <p className="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">154</p>
                            </div>
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                                <h3 className="text-sm font-medium text-gray-500">Đã bán</h3>
                                <p className="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">43</p>
                            </div>
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                                <h3 className="text-sm font-medium text-gray-500">Đang hiển thị</h3>
                                <p className="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">111</p>
                            </div>
                        </div>

                        {/* Danh sách bất động sản mới */}
                        <div className="col-span-1 md:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                            <h2 className="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Bất động sản gần đây</h2>
                            <ul className="divide-y divide-gray-200 dark:divide-gray-700">
                                <li className="py-3">
                                    <div className="flex justify-between">
                                        <span className="text-gray-700 dark:text-gray-200">Căn hộ Sunrise City</span>
                                        <span className="text-sm text-gray-500">15/04/2025</span>
                                    </div>
                                    <p className="text-sm text-gray-500">Quận 7, TP.HCM</p>
                                </li>
                                <li className="py-3">
                                    <div className="flex justify-between">
                                        <span className="text-gray-700 dark:text-gray-200">Biệt thự Thảo Điền</span>
                                        <span className="text-sm text-gray-500">13/04/2025</span>
                                    </div>
                                    <p className="text-sm text-gray-500">Quận 2, TP.HCM</p>
                                </li>
                                <li className="py-3">
                                    <div className="flex justify-between">
                                        <span className="text-gray-700 dark:text-gray-200">Shophouse Vinhomes</span>
                                        <span className="text-sm text-gray-500">12/04/2025</span>
                                    </div>
                                    <p className="text-sm text-gray-500">Bình Thạnh, TP.HCM</p>
                                </li>
                            </ul>
                        </div>

                        {/* Biểu đồ hoặc thống kê */}
                        <div className="col-span-1 bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                            <h2 className="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Thống kê</h2>
                            <div className="text-center text-gray-500 dark:text-gray-400">
                                Biểu đồ đang được cập nhật...
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </AppLayout>
    );
}
