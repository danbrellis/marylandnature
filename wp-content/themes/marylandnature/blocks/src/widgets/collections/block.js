const { InspectorControls } = wp.blockEditor;
const { registerBlockType } = wp.blocks;
const {
  PanelBody,
  TextControl,
  SelectControl,
  ToggleControl,
  ServerSideRender,
} = wp.components;

import "./editor.scss";

registerBlockType("nhsm-widgets/collections", {
  title: "Collections",
  icon: "grid-view",
  category: "widgets",
  edit({ attributes, className, setAttributes }) {
    return (
      <div className="container">
        <InspectorControls>
          <PanelBody title="Collections Settings" initialOpen={true}>
            <TextControl
              onChange={(value) =>
                setAttributes({
                  count: value,
                })
              }
              label="Number of results to display"
              value={attributes.count}
            />
            <SelectControl
              label="Display Format"
              value={attributes.format}
              options={[
                { label: "Condensed", value: "stamp" },
                { label: "Card", value: "card" },
              ]}
              onChange={(value) =>
                setAttributes({
                  format: value,
                })
              }
            />
            <SelectControl
              label="Order By"
              value={attributes.order}
              options={[
                { label: "Alphabetically", value: "title" },
                { label: "Randomly", value: "rand" },
              ]}
              onChange={(value) =>
                setAttributes({
                  order: value,
                })
              }
            />
            <ToggleControl
              label="Wrap for Grid"
              checked={attributes.wrapGrid}
              onChange={() =>
                setAttributes({
                  wrapGrid: !attributes.wrapGrid,
                })
              }
            />
          </PanelBody>
        </InspectorControls>
        <ServerSideRender
          block="nhsm-widgets/collections"
          className={`nhsm-widget-collections nhsm-widget-collections--${
            attributes.wrapGrid ? "grid" : "list"
          }`}
          attributes={attributes}
        />
      </div>
    );
  },
});
