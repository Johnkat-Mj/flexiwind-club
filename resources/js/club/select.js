// import { Select } from "@flexilla/select";
import { Select } from "./../../../../../flexilla/packages/select/src";


export function SelectPlugin(Alpine) {
    Alpine.directive("f-select", (el, {}, { cleanup }) => {
        const select = new Select(el);
        cleanup(() => {
            select.cleanup();
        });
    });
}
