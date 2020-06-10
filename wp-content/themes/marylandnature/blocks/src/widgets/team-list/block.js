const { InspectorControls } = wp.blockEditor;
const { registerBlockType } = wp.blocks;
const { PanelBody, SelectControl, ServerSideRender } = wp.components;
const { withSelect, withDispatch } = wp.data;

//import "./style.scss";
import "./editor.scss";

registerBlockType("nhsm-widgets/team-list", {
  title: "Team List",
  icon: "groups",
  category: "widgets",
  edit({ attributes, className, setAttributes }) {
    function SelectControlGen({ roles }) {
      let options = [];
      if (roles) {
        options = roles.map((role) => {
          return {
            label: role.name.replace(/&amp;/g, "&"),
            value: role.slug,
          };
        });
        options.unshift({ value: 0, label: "Please select one" });
      } else {
        options.push({ value: 0, label: "Loading..." });
      }

      return (
        <SelectControl
          label="Select role to display"
          value={attributes.role}
          options={options}
          onChange={(role) => {
            setAttributes({ role });
          }}
        />
      );
    }
    const TaxSelectControl = withSelect((select) => ({
      roles: select("core").getEntityRecords("taxonomy", "nhsm_role", {
        per_page: -1,
      }),
    }))(SelectControlGen);

    return (
      <div className="container nhsm_widgets_team_list">
        <InspectorControls>
          <PanelBody title="Team List Settings" initialOpen={true}>
            <TaxSelectControl />
          </PanelBody>
        </InspectorControls>
        <ServerSideRender
          block="nhsm-widgets/team-list"
          className="nhsm_widgets_team_list_grid"
          attributes={attributes}
        />
      </div>
    );
  },
});
