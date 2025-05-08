import { Button } from '@/components/ui/button';
import { Property } from '@/types';
import PropertyList from '@/components/properties/propertyIndex'; // ✅ Renamed to avoid conflict
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';

const breadcrumbs = [
    {
        title: 'Bất động sản',
        href: '/properties',
    },
];

interface PropertyIndexProps {
    properties: Property[];
    onEdit: (property: Property) => void;
    onDelete: (id: number) => void;
    onCreate: () => void;
}

export default function PropertyIndexPage({ properties, onEdit, onDelete, onCreate }: PropertyIndexProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quản lý bất động sản" />
            <div className="flex h-full flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border p-4 md:min-h-min">
                    <PropertyList
                        properties={properties}
                        onEdit={onEdit}
                        onDelete={onDelete}
                        onCreate={onCreate}
                    />
                </div>
            </div>
        </AppLayout>
    );
}
