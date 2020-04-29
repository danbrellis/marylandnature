const { InspectorControls } = wp.blockEditor;
const { registerBlockType } = wp.blocks;
const { PanelBody, NumberControl, ServerSideRender } = wp.components;

import "./style.scss";
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
            <div>
              <NumberControl
                onChange={(number) =>
                  setAttributes({
                    count: number,
                  })
                }
                min={1}
                value={attributes.count}
                isShiftStepEnabled={false}
              />
            </div>
          </PanelBody>
        </InspectorControls>
        <ServerSideRender
          block="nhsm-widgets/collections"
          className="blocks-gallery-grid"
          attributes={attributes}
        />
      </div>
    );
  },
});
