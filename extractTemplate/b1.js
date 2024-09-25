const fs = require('fs');
const { JSDOM } = require('jsdom');

// Fonction pour extraire le contenu HTML et générer le JSON et le PHP dynamique
function extractAndGenerate(htmlContent, phpOutputPath, jsonOutputPath) {
    const dom = new JSDOM(htmlContent);
    const document = dom.window.document;

    const jsonData = {
        sections: []
    };

    function processNode(node, sectionId) {
        // Ignorer les noeuds de texte vides
        if (node.nodeType === dom.window.Node.TEXT_NODE) {
            const textContent = node.textContent.trim();
            if (textContent === '') return;

            // Trouver la section correspondante
            const section = jsonData.sections.find(sec => sec.id === sectionId);
            if (section) {
                if (!section.content.paragraphs) {
                    section.content.paragraphs = [];
                }
                section.content.paragraphs.push(textContent.replace(/'/g, "\\'")); // Échapper les apostrophes
            }
            return;
        }

        const tagName = node.tagName.toLowerCase();
        let sectionIdToProcess = sectionId;

        // Gérer les sections
        if (tagName === 'section') {
            sectionIdToProcess = node.id || `section_${jsonData.sections.length + 1}`;
            jsonData.sections.push({ id: sectionIdToProcess, content: {}, styles: {} });
        }

        let styles = {};
        if (node.hasAttributes()) {
            for (let attr of node.attributes) {
                if (attr.name === 'style') {
                    const styleAttributes = attr.value.split(';').filter(style => style.trim() !== '');
                    styleAttributes.forEach(style => {
                        const [property, value] = style.split(':').map(s => s.trim());
                        if (property && value) {
                            styles[property.replace('-', '_')] = value;
                        }
                    });
                }
            }
        }

        // Ajouter les styles à la section
        if (Object.keys(styles).length > 0) {
            const section = jsonData.sections.find(sec => sec.id === sectionIdToProcess);
            if (section) {
                section.styles = { ...section.styles, ...styles };
            }
        }

        // Traiter les enfants du noeud
        for (let childNode of node.childNodes) {
            processNode(childNode, sectionIdToProcess);
        }
    }

    // Traiter chaque élément sous le body
    for (let node of document.body.childNodes) {
        processNode(node);
    }

    // Générer le contenu PHP (à personnaliser selon tes besoins)
    let phpContent = "/* PHP output */\n";
    jsonData.sections.forEach(section => {
        phpContent += `<section id="${section.id}">\n`;
        if (section.content.paragraphs) {
            section.content.paragraphs.forEach(paragraph => {
                phpContent += `    <p>{{ section.content.paragraphs['${paragraph}'] }}</p>\n`;
            });
        }
        phpContent += `</section>\n`;
    });

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
