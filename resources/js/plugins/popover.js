import { Popover as FlexillaPopover } from "@flexilla/popover";

export function PopoverPlugin(Alpine) {
    Alpine.directive("popover", (el, {}, { cleanup }) => {
       const popover_ = new FlexillaPopover(el)
        cleanup(() => {
            popover_.cleanup()
        });
    });
}
