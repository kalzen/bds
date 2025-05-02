import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: number;
    full_name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    phone?: string;
    [key: string]: unknown;
}

export interface Property {
    id: number;
    user_id?: number; // Optional
    project_id?: number; // Optional
    listing_type_id?: number; // Optional
    category_id?: number; // Optional
    location_id?: number; // Optional
    name: string;
    description: string;
    price: number;
    amenities: PropertyAmenity[];
    attributes: PropertyAttribute[];
}

export interface PropertyAmenity {
    amenity: Amenities;
    value: string;
}

export interface PropertyAttribute {
    attribute: Attributes;
    value: string | number;
}

export interface City {
    id: number;
    name: string;
    state: string;
    country: string;
}

export interface District{
    id: number;
    name: string;
    city: City;
}

export interface Ward{
    id: number;
    name: string;
    district: District;
}

export interface Amenities{
    id: number;
    name: string;
}

export interface Attributes{
    id: number;
    name: string;
    data_type : string;
}

export interface ListingType{
    id: number;
    name: string;
}

export interface PropertyCategory{
    id: number;
    name: string;
}
