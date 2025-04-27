// src/components/CityList.tsx
interface City {
    id: number;
    name: string;
}

interface CityListProps {
    cities: City[];
}

export default function CityList({ cities }: CityListProps) {
    return (
        <div className="p-4">
            {!cities || cities.length === 0 ? (
                <p className="text-gray-500">Không có thành phố nào.</p>
            ) : (
                <ul className="list-disc pl-5">
                    {cities.map((city) => (
                        <li key={city.id}>{city.name}</li>
                    ))}
                </ul>
            )}

        </div>
    );
}
