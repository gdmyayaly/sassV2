const fs = require('fs');
const { JSDOM } = require('jsdom');

// Fonction pour extraire le texte, les styles et générer le JSON et le PHP dynamique
function extractAndGenerate(htmlContent, phpOutputPath, jsonOutputPath) {
    const dom = new JSDOM(htmlContent);
    const document = dom.window.document;

    let phpContent = "";
    const jsonData = {
        content: {
            text: {},
            images: {},
            links: {}
        },
        styles: {}
    };

    let elementCounter = 0; // Compteur pour les éléments

    // Fonction récursive pour parcourir tous les éléments enfants et extraire le contenu et les styles
    function processNode(node) {
        // Ignorer les noeuds de texte vides
        if (node.nodeType === dom.window.Node.TEXT_NODE) {
            const textContent = node.textContent.trim();
            if (textContent === '') {
                return;
            }

            // Créer une clé unique pour le texte
            const textKey = `text_${elementCounter}`;
            elementCounter++;

            // Ajouter le contenu textuel au JSON
            jsonData.content.text[textKey] = textContent.replace(/'/g, "\\'"); // Échapper les apostrophes

            // Ajouter le texte au fichier PHP avec la variable Twig
            phpContent += `{{ section.content.text['${textKey}'] }}\n`;
            return;
        }

        const tagName = node.tagName.toLowerCase();
        let attributes = "";

        // Gérer les attributs de l'élément (classes, id, etc.)
        if (node.hasAttributes()) {
            for (let attr of node.attributes) {
                if (attr.name === 'style') {
                    // Extraire les styles calculés
                    const computedStyles = dom.window.getComputedStyle(node);
                    const styleProperties = ['color', 'font-size', 'text-align', 'font-weight', 'background-color'];
                    const styles = {};

                    styleProperties.forEach((prop) => {
                        const value = computedStyles.getPropertyValue(prop);
                        if (value && value !== '') {
                            styles[prop.replace('-', '_')] = value;
                        }
                    });

                    if (Object.keys(styles).length > 0) {
                        // Créer une clé unique pour les styles
                        const styleKey = `style_${elementCounter}`;
                        jsonData.styles[styleKey] = styles;
                        attributes += ` style="`;
                        for (let [prop, val] of Object.entries(styles)) {
                            attributes += `${prop.replace('_', '-')}: {{ section.styles['${styleKey}']['${prop}'] }}; `;
                        }
                        attributes += `"`;
                    }
                } else if (tagName === 'img' && attr.name === 'src') {
                    // Gérer les images
                    const imgKey = `image_${elementCounter}`;
                    jsonData.content.images[imgKey] = node.getAttribute('src');

                    // Remplacer l'attribut src par une variable Twig
                    attributes += ` src="{{ section.content.images['${imgKey}'] }}"`;
                } else if (tagName === 'a' && attr.name === 'href') {
                    // Gérer les liens
                    const linkKey = `link_${elementCounter}`;
                    jsonData.content.links[linkKey] = node.getAttribute('href');

                    // Remplacer l'attribut href par une variable Twig
                    attributes += ` href="{{ section.content.links['${linkKey}'] }}"`;
                } else {
                    // Ajouter les autres attributs tels quels
                    attributes += ` ${attr.name}="${attr.value}"`;
                }
            }
        }

        // Ouvrir la balise dans le fichier PHP
        phpContent += `<${tagName}${attributes}>`;

        // Parcourir les enfants du noeud
        for (let childNode of node.childNodes) {
            processNode(childNode);
        }

        // Fermer la balise
        phpContent += `</${tagName}>\n`;
    }

    // Traiter chaque élément sous le body
    for (let node of document.body.childNodes) {
        processNode(node);
    }

    // Écrire le contenu PHP généré dans le fichier de sortie
    fs.writeFileSync(phpOutputPath, phpContent, 'utf8');
    console.log(`Fichier PHP généré : ${phpOutputPath}`);

    // Écrire le contenu JSON dans le fichier de sortie
    const jsonOutput = JSON.stringify(jsonData, null, 2);
    fs.writeFileSync(jsonOutputPath, jsonOutput, 'utf8');
    console.log(`Fichier JSON généré : ${jsonOutputPath}`);
}

// Lire le fichier HTML d'entrée
const htmlFilePath = 'input.html'; // Chemin vers ton fichier HTML d'entrée
const htmlContent = fs.readFileSync(htmlFilePath, 'utf8');

// Générer le fichier PHP et JSON
extractAndGenerate(htmlContent, 'output.php', 'output.json');
