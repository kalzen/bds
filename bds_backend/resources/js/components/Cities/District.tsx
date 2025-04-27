import { router } from '@inertiajs/react';
import { useState, useEffect } from 'react';

interface District {
    id: number;
    name: string;
    city?: {
        id: number;
        name: string;
    };
}

interface City {
    id: number;
    name: string;
}

interface DistrictIndexProps {
    districts: District[];
    cities: City[];
    filters?: {
        search?: string;
        city_id?: string;
    };
    emptyMessage?: string;
}

export default function DistrictIndex({
                                          districts = [],
                                          cities = [],
                                          filters = {},
                                          emptyMessage = 'Không có dữ liệu.',
                                      }: DistrictIndexProps) {
    const [search, setSearch] = useState(filters?.search || '');
    const [cityId, setCityId] = useState(filters?.city_id || '');

    console.log(districts);

    useEffect(() => {
        const timeout = setTimeout(() => {
            router.get(route('location'), { search, city_id: cityId }, {
                preserveState: true,
                replace: true,
            });
        }, 300);

        return () => clearTimeout(timeout);
    }, [search, cityId]);

    return (
        <div className="p-4 space-y-6">
            <div className="flex flex-wrap gap-4 max-w-2xl">
                <input
                    type="text"
                    value={search}
                    onChange={(e) => setSearch(e.target.value)}
                    placeholder="Tìm kiếm quận theo tên"
                    className="border p-2 rounded w-full md:w-1/2"
                />
                <select
                    value={cityId}
                    onChange={(e) => setCityId(e.target.value)}
                    className="border p-2 rounded w-full md:w-1/2"
                >
                    <option value="">Tất cả thành phố</option>
                    {cities.map((city) => (
                        <option key={city.id} value={city.id}>
                            {city.name}
                        </option>
                    ))}
                </select>
            </div>

            {districts.length === 0 ? (
                <div className="text-gray-500 mt-6">
                    {emptyMessage ?? 'Không có dữ liệu.'}
                </div>
            ) : (
                <table className="w-full table-auto border mt-6">
                    <thead className="bg-gray-100">
                    <tr>
                        <th className="border px-4 py-2 text-left">Tên quận</th>
                        <th className="border px-4 py-2 text-left">Thành phố</th>
                    </tr>
                    </thead>
                    <tbody>
                    {districts.map((district) => (
                        <tr key={district.id}>
                            <td className="border px-4 py-2">{district.name}</td>
                            <td className="border px-4 py-2">{district.city?.name ?? '-'}</td>
                        </tr>
                    ))}
                    </tbody>
                </table>
            )}
        </div>
    );
}
