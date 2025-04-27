import { router } from '@inertiajs/react';
import { useState, useEffect } from 'react';

interface Ward {
    id: number;
    name: string;
    district?: {
        id: number;
        name: string;
        city: {
            id: number;
            name: string;
        };
    };
}

interface District {
    id: number;
    name: string;
}

interface WardIndexProps {
    wards?: Ward[];
    districts: District[];
    filters?: {
        search?: string;
        district_id?: string;
    };
    emptyMessage?: string;
    isEditMode?: boolean;
    selectedWard?: Ward;  // Dùng khi chọn phường xã để sửa
    onWardDelete?: (id: number) => void;  // Callback khi xóa phường xã
}

export default function WardIndex({
                                      wards = [],
                                      districts = [],
                                      filters = {},
                                      emptyMessage = 'Không có dữ liệu.',
                                      isEditMode = false,
                                      selectedWard,
                                      onWardDelete,
                                  }: WardIndexProps) {
    const [search, setSearch] = useState(filters?.search || '');
    const [districtId, setDistrictId] = useState(filters?.district_id || '');
    const [name, setName] = useState(selectedWard?.name || '');  // Tên phường xã
    const [district, setDistrict] = useState(selectedWard?.district?.id || '');  // Quận huyện
    const [isProcessing, setIsProcessing] = useState(false);  // Đang xử lý thao tác (thêm/sửa/xóa)
    const [currentWard, setCurrentWard] = useState<Ward | undefined>(selectedWard); // Trạng thái phường xã đang chọn

    useEffect(() => {
        const timeout = setTimeout(() => {
            router.get(route('location'), { search, district_id: districtId }, {
                preserveState: true,
                replace: true,
            });
        }, 300);

        return () => clearTimeout(timeout);
    }, [search, districtId]);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setIsProcessing(true);

        if (isEditMode && currentWard) {
            // Cập nhật phường xã
            await router.put(route('location.wards.update', currentWard.id), {
                name,
                district_id: district,
            });
        } else {
            // Thêm phường xã mới
            await router.post(route('location.wards.store'), {
                name,
                district_id: district,
            });
        }

        setIsProcessing(false);
    };

    const handleDelete = async () => {
        if (onWardDelete && currentWard) {
            if (confirm('Bạn có chắc chắn muốn xóa phường xã này?')) {
                setIsProcessing(true);
                await onWardDelete(currentWard.id);
                setIsProcessing(false);
            }
        }
    };

    return (
        <div className="p-4 space-y-6">
            {/* Form thêm hoặc sửa */}
            <form onSubmit={handleSubmit} className="space-y-4">
                <div>
                    <label className="block text-sm">Tên phường xã</label>
                    <input
                        type="text"
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                        placeholder="Nhập tên phường xã"
                        className="border p-2 w-full"
                    />
                </div>

                <div>
                    <label className="block text-sm">Chọn Quận/Huyện</label>
                    <select
                        value={district}
                        onChange={(e) => setDistrict(e.target.value)}
                        className="border p-2 w-full"
                    >
                        <option value="">Chọn Quận/Huyện</option>
                        {districts.map((district) => (
                            <option key={district.id} value={district.id}>
                                {district.name}
                            </option>
                        ))}
                    </select>
                </div>

                <div className="flex gap-4">
                    <button
                        type="submit"
                        disabled={isProcessing}
                        className="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50"
                    >
                        {isProcessing ? (isEditMode ? 'Đang cập nhật...' : 'Đang tạo...') : (isEditMode ? 'Cập nhật' : 'Thêm Phường Xã')}
                    </button>

                    {isEditMode && currentWard && (
                        <button
                            type="button"
                            onClick={handleDelete}
                            className="bg-red-500 text-white px-4 py-2 rounded"
                        >
                            Xóa Phường Xã
                        </button>
                    )}
                </div>
            </form>

            {/* Hiển thị bảng phường xã */}
            <div className="space-y-6">
                <div className="flex flex-wrap gap-4 max-w-2xl">
                    <input
                        type="text"
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        placeholder="Tìm kiếm phường xã theo tên"
                        className="border p-2 rounded w-full md:w-1/2"
                    />
                    <select
                        value={districtId}
                        onChange={(e) => setDistrictId(e.target.value)}
                        className="border p-2 rounded w-full md:w-1/2"
                    >
                        <option value="">Tất cả quận huyện</option>
                        {districts.map((district) => (
                            <option key={district.id} value={district.id}>
                                {district.name}
                            </option>
                        ))}
                    </select>
                </div>

                {wards.length === 0 ? (
                    <div className="text-gray-500 mt-6">{emptyMessage}</div>
                ) : (
                    <table className="w-full table-auto border mt-6">
                        <thead className="bg-gray-100">
                        <tr>
                            <th className="border px-4 py-2 text-left">Tên phường xã</th>
                            <th className="border px-4 py-2 text-left">Quận huyện</th>
                            <th className="border px-4 py-2 text-left">Thành phố</th>
                            <th className="border px-4 py-2 text-left">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        {wards.map((ward) => (
                            <tr key={ward.id}>
                                <td className="border px-4 py-2">{ward.name}</td>
                                <td className="border px-4 py-2">{ward.district?.name ?? '-'}</td>
                                <td className="border px-4 py-2">{ward.district?.city?.name ?? '-'}</td>
                                <td className="border px-4 py-2">
                                    <button
                                        onClick={() => {
                                            setName(ward.name);
                                            setDistrict(ward.district?.id.toString() || '');
                                            setCurrentWard(ward); // Cập nhật trạng thái selectedWard
                                        }}
                                        className="text-blue-500"
                                    >
                                        Sửa
                                    </button>
                                    <button
                                        onClick={() => handleDelete()}
                                        className="ml-2 text-red-500"
                                    >
                                        Xóa
                                    </button>
                                </td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                )}
            </div>
        </div>
    );
}
