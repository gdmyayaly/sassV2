export interface ClientModel{
    id: number;
    logo: string;
    nomEntreprise: string;
    description: string;
    telephoneRepresentant: string;
    emailEntreprise: string;
    adresse: string;
    websiteType: string;
    galerieSizeLimit: number;
    galerieSizeActuel: number;
    dateDebutAbonnement: string;
    dateFinAbonnement: string;
    isActive: boolean;
    linkWebsite: string;
    createdAt:string;
}