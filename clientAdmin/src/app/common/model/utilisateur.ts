export interface Utilisateur {
	id: number,
	username: string,
	isActive: boolean,
	firstConnection: boolean,
	utilisateur: {
		id: number,
		prenom: string,
		nom: string,
		telephone: string,
		email: string,
		entreprise: {
			id: number,
			logo: string,
			nomEntreprise: string,
			description: string,
			telephoneRepresentant: string,
			emailEntreprise: string,
			adresse: string,
			websiteType: string,
			galerieSizeLimit: number,
			galerieSizeActuel: number,
			dateDebutAbonnement: string,
			dateFinAbonnement: string,
			isActive: boolean,
			linkWebsite: string
		}
	}
}
