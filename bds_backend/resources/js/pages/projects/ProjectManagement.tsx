import ProjectForm from '@/components/properties/project/projectForm';
import AppLayout from '@/layouts/app-layout';
import { District, Project, Provinces, Ward } from '@/types';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

const breadcrumbs = [
    {
        title: 'Bất động sản',
        href: '/properties',
    },
];

export default function ProjectManagementPage({
    projects = [],
    provinces = [],
    districts = [],
    wards = [],
    emptyMessage = 'Không có bất động sản nào.',
    auth,
}: {
    projects: Project[];
    provinces: Provinces[];
    districts: District[];
    wards: Ward[];
    emptyMessage: string | null;
    auth: {
        user: {
            id: number;
            name: string;
        };
    };
}) {
    const [editingProject, setEditingProject] = useState<Project | null>(null);

    const handleSave = (project: Partial<Project>) => {
        console.log('Project saved:', project);
        setEditingProject(null);
    };

    const handleClose = () => {
        setEditingProject(null);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quản lý bất động sản" />

            <div className="flex h-full flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border p-4 md:min-h-min">
                    <ProjectForm
                        projects={projects}
                        provinces={provinces}
                        districts={districts}
                        wards={wards}
                        onSave={handleSave}
                        onClose={handleClose} />
                    {projects.length === 0 && <div className="mt-4 text-center text-gray-500">{emptyMessage}</div>}
                </div>
            </div>
        </AppLayout>
    );
}
