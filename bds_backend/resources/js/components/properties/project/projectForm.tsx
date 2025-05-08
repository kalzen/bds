import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { District, Project, Provinces, Ward } from '@/types';
import { useForm } from '@inertiajs/react';
import { useState } from 'react';

interface ProjectFormProps {
    projects: Project[];
    provinces: Provinces[];
    districts: District[];
    wards: Ward[];
    onSave: (project: Partial<Project>) => void;
    onClose: () => void;
}

interface ProjectFormData {
    name: string;
    investor: string;
    number_of_units: string;
    location_id: string;
    total_area: string;
    description: string;
    start_date: string;
    end_date: string;
    province_id: number | string;
    district_id: number | string;
    ward_id: number | string;
    address: string;
}

export default function ProjectForm({ projects, provinces, districts, wards, onSave, onClose }: ProjectFormProps) {
    const [editingProject, setEditingProject] = useState<Project | null>(null);
    const [autoAddress, setAutoAddress] = useState('');
    const [addressDetail, setAddressDetail] = useState('');
    console.log(projects);
    const initialFormData: ProjectFormData = {
        name: '',
        investor: '',
        number_of_units: '',
        location_id: '',
        total_area: '',
        description: '',
        start_date: '',
        end_date: '',
        province_id: '',
        district_id: '',
        ward_id: '',
        address: '',
    };

    const { data, setData, post, put, delete: destroy, processing, errors, reset } = useForm<Partial<ProjectFormData>>(initialFormData);

    const isEdit = Boolean(editingProject);

    function normalizeFormToProject(data: Partial<ProjectFormData>): Partial<Project> {
        return {
            ...data,
            province_id: data.province_id ? Number(data.province_id) : undefined,
            district_id: data.district_id ? Number(data.district_id) : undefined,
            ward_id: data.ward_id ? Number(data.ward_id) : undefined,
            number_of_units: data.number_of_units ?? '', // đảm bảo đúng kiểu string
        };
    }

    const handleProvinceChange = (provinceId: string) => {
        setData('province_id', provinceId);
        setData('district_id', '');
        setData('ward_id', '');
        updateAddress(provinceId, '', '');
    };

    const handleDistrictChange = (districtId: string) => {
        const currentProvinceId = data.province_id;
        setData('district_id', districtId);
        setData('ward_id', '');
        updateAddress(currentProvinceId as string, districtId, '');
    };

    const updateAddress = (provinceId: string, districtId: string, wardId: string) => {
        const province = provinces?.find((p) => p.code === provinceId);
        const district = districts?.find((d) => d.code === districtId);
        const ward = wards?.find((w) => w.code === wardId);

        const autoAddr = `${ward?.name || ''}, ${district?.name || ''}, ${province?.name || ''}`.trim();
        setAutoAddress(autoAddr);
        const fullAddr = `${addressDetail}, ${autoAddr}`.trim().replace(/^,/, '');
        setData('address', fullAddr);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        const normalizedData = normalizeFormToProject(data);

        console.log('data line95: ', data);

        if (isEdit && editingProject) {
            put(route('projects.update', editingProject.id), {
                onSuccess: () => {
                    reset();
                    setEditingProject(null);
                    onSave(normalizedData);
                },
            });
        } else {
            // Chuyển đổi kiểu nếu cần thiết
            const normalizedData = {
                ...data,
                province_id: Number(data.province_id),
                district_id: Number(data.district_id),
                ward_id: Number(data.ward_id),
            };

            setData(normalizedData); // cập nhật lại nếu bạn cần ép kiểu

            post(route('projects.store'), {
                onSuccess: () => {
                    reset();
                    onSave(normalizedData);
                },
            });
        }
    };

    const handleEdit = (project: Project) => {
        setEditingProject(project);
        setData({
            name: project.name,
            investor: project.investor,
            number_of_units: project.number_of_units,
            location_id: project.location_id,
            total_area: project.total_area,
            description: project.description,
            start_date: project.start_date,
            end_date: project.end_date,
            province_id: project.province_id,
            district_id: project.district_id,
            ward_id: project.ward_id,
            address: project.address,
        });
        setAddressDetail(project.address.split(',')[0] ?? '');
        updateAddress(String(project.province_id), String(project.district_id), String(project.ward_id));
    };

    const handleDelete = (projectId: number) => {
        if (!confirm('Bạn có chắc chắn muốn xóa dự án này?')) return;

        destroy(route('projects.destroy', projectId), {
            onSuccess: () => {
                onSave({}); // Refresh or sync state post-delete
            },
        });
    };

    return (
        <div className="space-y-6 p-4">
            <form onSubmit={handleSubmit} className="space-y-4">
                <Input placeholder="Tên dự án" value={data.name || ''} onChange={(e) => setData('name', e.target.value)} />
                <InputError message={errors.name} />

                <Input placeholder="Nhà đầu tư" value={data.investor || ''} onChange={(e) => setData('investor', e.target.value)} />
                <InputError message={errors.investor} />

                <Input
                    type={'number'}
                    placeholder="Số bất động sản (Căn)"
                    value={data.number_of_units || ''}
                    onChange={(e) => setData('number_of_units', e.target.value)}
                />
                <InputError message={errors.number_of_units} />

                {/* Province */}
                <Select value={data.province_id?.toString() || ''} onValueChange={handleProvinceChange}>
                    <SelectTrigger className="w-full">
                        <SelectValue placeholder="Chọn tỉnh/thành phố" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Tỉnh/Thành</SelectLabel>
                            {provinces?.map((province) => (
                                <SelectItem key={province.id} value={province.code}>
                                    {province.name}
                                </SelectItem>
                            ))}
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <InputError message={errors.province_id} />

                {/* District */}
                <Select value={data.district_id?.toString() || ''} onValueChange={handleDistrictChange}>
                    <SelectTrigger className="w-full">
                        <SelectValue placeholder="Chọn quận/huyện" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Quận/Huyện</SelectLabel>
                            {districts
                                ?.filter((d) => d.parent_code === data.province_id)
                                .map((district) => (
                                    <SelectItem key={district.id} value={district.code}>
                                        {district.name}
                                    </SelectItem>
                                ))}
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <InputError message={errors.district_id} />

                {/* Ward */}
                <Select
                    value={data.ward_id?.toString() || ''}
                    onValueChange={(wardCode) => {
                        setData('ward_id', wardCode);
                        updateAddress(data.province_id as string, data.district_id as string, wardCode);
                    }}
                >
                    <SelectTrigger className="w-full">
                        <SelectValue placeholder="Chọn phường/xã" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Phường/Xã</SelectLabel>
                            {wards
                                ?.filter((w) => w.parent_code === data.district_id)
                                .map((ward) => (
                                    <SelectItem key={ward.id} value={ward.code}>
                                        {ward.name}
                                    </SelectItem>
                                ))}
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <InputError message={errors.ward_id} />


                {/* Address Detail Input */}
                <div className="mt-2">
                    <label>Địa chỉ</label>
                    <input
                        type="text"
                        value={addressDetail}
                        onChange={(e) => {
                            const detail = e.target.value;
                            setAddressDetail(detail);
                            setData('address', `${detail}, ${autoAddress}`.trim().replace(/^,/, ''));
                        }}
                        className="w-full rounded border px-2 py-1"
                        placeholder="Ví dụ: Số 10 ngõ 5..."
                    />
                </div>

                <Input placeholder="Tổng diện tích (m2)" value={data.total_area || ''} onChange={(e) => setData('total_area', e.target.value)} />
                <InputError message={errors.total_area} />

                <Textarea placeholder="Mô tả" value={data.description || ''} onChange={(e) => setData('description', e.target.value)} />
                <InputError message={errors.description} />

                <Input type="date" placeholder="Ngày bắt đầu" value={data.start_date || ''} onChange={(e) => setData('start_date', e.target.value)} />
                <InputError message={errors.start_date} />

                <Input type="date" placeholder="Ngày kết thúc" value={data.end_date || ''} onChange={(e) => setData('end_date', e.target.value)} />
                <InputError message={errors.end_date} />

                <div className="flex gap-2">
                    <Button type="submit" disabled={processing}>
                        {processing ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Thêm mới'}
                    </Button>
                    {isEdit && (
                        <Button
                            type="button"
                            variant="ghost"
                            onClick={() => {
                                reset();
                                setEditingProject(null);
                            }}
                        >
                            Hủy
                        </Button>
                    )}
                </div>
            </form>

            <div className="mt-6">
                <h3 className="mb-4 text-lg font-bold">Danh sách dự án</h3>

                <div className="overflow-auto rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Tên D.A</TableHead>
                                <TableHead>Nhà đầu tư</TableHead>
                                <TableHead>Số căn hộ</TableHead>
                                <TableHead>Địa chỉ</TableHead>
                                <TableHead>Diện tích</TableHead>
                                <TableHead>Mô tả</TableHead>
                                <TableHead>Ngày khánh thành</TableHead>
                                <TableHead>Ngày kết thúc</TableHead>
                                <TableHead className="text-right">Thao tác</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {projects.length > 0 ? (
                                projects.map((project) => (
                                    <TableRow key={project.id}>
                                        <TableCell>{project.name}</TableCell>
                                        <TableCell>{project.investor}</TableCell>
                                        <TableCell>{project.number_of_units} Căn</TableCell>
                                        <TableCell>{project.location?.address || 'N/A'}</TableCell>
                                        <TableCell>{project.total_area}</TableCell>
                                        <TableCell>{project.description}</TableCell>
                                        <TableCell>{project.start_date}</TableCell>
                                        <TableCell>{project.end_date}</TableCell>
                                        <TableCell className="text-right">
                                            <Button size="sm" onClick={() => handleEdit(project)}>
                                                Sửa
                                            </Button>
                                            <Button size="sm" variant="destructive" onClick={() => handleDelete(project.id)}>
                                                Xóa
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={9} className="text-muted-foreground py-4 text-center">
                                        Không có dự án nào.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>
    );
}
