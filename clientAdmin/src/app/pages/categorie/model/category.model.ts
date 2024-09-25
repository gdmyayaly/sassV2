import { SousCategoryModel } from "./sous-category.model";

export interface CategoryModel{
    id:number;
    nom:string;
    description?:string;
    image?:string;
    creteadAt:string;
    slug:string;
    sousCategoryProducts:Array<SousCategoryModel>;
}