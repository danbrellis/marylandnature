import "./common/contact/block";
import "./common/page-card/block";
import "./featurettes/collections/block";
import "./featurettes/newsletter-signup/block";
import "./layout/grid/block";
import "./widgets/collections/block";
import "./widgets/team-list/block";

wp.domReady(() => {
  wp.blocks.registerBlockStyle("core/button", {
    name: "normal",
    label: "Normal",
  });
  wp.blocks.registerBlockStyle("core/button", {
    name: "small",
    label: "Small",
  });
  wp.blocks.registerBlockStyle("core/button", {
    name: "large",
    label: "large",
  });
  wp.blocks.registerBlockStyle("core/button", {
    name: "prominent",
    label: "Prominent",
  });

  wp.blocks.unregisterBlockStyle("core/button", "fill");
  wp.blocks.unregisterBlockStyle("core/button", "outline");
  wp.blocks.unregisterBlockStyle("core/button", "rounded");
});
