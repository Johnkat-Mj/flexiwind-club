# Flexiwind Pro — dépôt privé

Composants, blocks, exemples et templates premium. **Rien d'autre.**

```
flexiwind-pro/
├─ registry-pro/views/components/
│  ├─ pro/                       ← composants premium  → <x-pro.select />
│  ├─ blocks-pro/                ← blocks premium
│  └─ examples-pro/              ← exemples des pages de doc pro
├─ registries-pro/*.json         ← index servi derrière licence
└─ src/                          ← une seule chose : enregistrer la source "pro"
```

## Ce qui ne doit JAMAIS arriver ici

**Du contenu de documentation.** Toute la doc — y compris celle des composants
premium — vit dans le dépôt public. Ce dépôt ne fournit que les artefacts que
cette doc référence.

**Une copie d'un composant gratuit.** `resources/views/components/ui/**` est
interdit. Si une primitive a besoin d'être corrigée, la correction part dans le
dépôt public et revient par `composer update`. C'est exactement la recopie
manuelle qu'on a supprimée : `site/` et `club/app/` avaient divergé sur presque
chacune des ~50 primitives avant cette réorganisation.

À mettre en CI, pour que ce soit une contrainte et pas une intention :

```bash
test -z "$(find resources/views/components/ui -type f 2>/dev/null)" \
  || { echo "Une primitive gratuite a été recopiée ici."; exit 1; }
```

## Composer une primitive gratuite

Un block premium écrit `<x-ui.button>` normalement : le package public enregistre
ses vues comme emplacement de vues, donc le tag résout dans l'app de Pro comme
dans un projet utilisateur.

Côté registry, l'entrée le déclare :

```json
"registryDependencies": ["@flexiwind/button", "@flexiwind/input"]
```

Le CLI installe alors les primitives depuis la source publique, puis le composant
premium depuis l'endpoint authentifié. Le code premium ne transite que pour un
licencié ; les dépendances gratuites restent publiques.

## Distribution

Le CLI supporte déjà des headers HTTP (`HttpUtils::getJson($url, $headers)`,
`RegistryVersionResolver`). Il reste à accepter la forme objet dans
`flexiwind.yaml` et à lire le token depuis `~/.flexiwind/auth.json` :

```yaml
registries:
  '@flexiwind': https://raw.githubusercontent.com/unoforge/flexiwind/main/registries/{name}.json
  '@flexiwind-pro':
    url: https://flexiwind.unoforge.com/r/{name}.json
    headers: { Authorization: "Bearer ${FLEXIWIND_TOKEN}" }
```
