export interface GalerieModel{
    cretedAt:string,
    deletedAt: string,
    documentNewName: string,
    documentOriginalName: string,
    documentSize: number
    documentType: string,
    documentUrl: string,
    id: number
    isDeleted: boolean
    passwordMedia?: string,
    path: string,
    showPublic: boolean
}