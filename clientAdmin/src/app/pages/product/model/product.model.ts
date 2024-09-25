import { CategoryModel } from "../../categorie/model/category.model";
import { VariationModel } from "../../config-website/variation-product/model/variation.model";

export interface ProductModel{
        id: number;
        nom: string;
        brefDescription: string,
        detailDescription: string,
        image: string,
        otherImage?: Array<string>,
        otherVideo?: Array<string>,
        prix?: number,
        quantity?: number,
        prixPromo?: number,
        promoStart?: string,
        promoEnd?: string,
        colors: Array<string>,
        createdAt: string,
        productVariationValues: Array<{id:number,value:Array<string>,variationProduct:VariationModel}>,
        entreprise: any,
        productCategoryValues: Array<{id:number,category:CategoryModel,sousCategory:CategoryModel}>
}