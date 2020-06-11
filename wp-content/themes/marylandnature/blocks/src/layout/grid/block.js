const { InnerBlocks } = wp.blockEditor;
const { registerBlockType } = wp.blocks;
const {
  PanelBody,
  TextControl,
  SelectControl,
  ToggleControl,
  ServerSideRender,
} = wp.components;

import "./editor.scss";

registerBlockType("nhsm-layout/grid", {
  title: "Card Grid",
  icon: "grid-view",
  category: "layout",
  edit({ attributes, className, setAttributes }) {
    return (
      <div className="card-grid-layout-container">
        <InnerBlocks allowedBlocks={["nhsm-common/page-card"]} />
      </div>
    );
  },
  save: ({ className }) => {
    return (
      <div className="two-column-grid__list">
        <InnerBlocks.Content />
      </div>
    );
  },
});
