// import { Autocomplete } from "@flexilla/autocomplete";
import { Autocomplete } from "./../../../../../flexilla/packages/autocomplete";


export function AutocompletePlugin(Alpine) {
    Alpine.directive("f-auto-complete", (el, {}, { cleanup }) => {
        const autoCompletion = new Autocomplete(el);
        cleanup(() => {
            autoCompletion.cleanup();
        });
    });
}
