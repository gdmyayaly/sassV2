export interface VariationModel{
    createdAt: string;
    id: number;
    nom: string;
    valeur: Array<string>,
    selected?:Array<string>,
    removed?:Array<string>,

}