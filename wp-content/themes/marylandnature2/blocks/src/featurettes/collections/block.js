const {
  InspectorControls,
  MediaUpload,
  PlainText,
  RichText,
  PanelColorSettings,
  InnerBlocks,
} = wp.blockEditor;
const { registerBlockType } = wp.blocks;
const { Button, Disabled, ServerSideRender } = wp.components;

import "./style.scss";
import "./editor.scss";

registerBlockType("nhsm-featurettes/collections", {
  title: "Collections CTA",
  icon: "grid-view",
  category: "nhsm-featurettes",
  attributes: {
    title: {
      source: "text",
      selector: ".nhsm-cta-collections__title",
    },
    lead: {
      source: "text",
      selector: ".nhsm-cta-collections__lead",
    },
    cta: {
      type: "string",
      source: "html",
      selector: ".nhsm-cta-collections__collectionsGridTitle",
    },
    componentStyles: {
      type: "object",
      backgroundImage: {},
      backgroundColor: "",
      color: "",
    },
    bgImageID: {
      type: "integer",
    },
  },
  edit({ attributes, className, setAttributes }) {
    const getImageButton = (openEvent) => {
      if (attributes.bgImageID) {
        return (
          <div className="img-container">
            <Button onClick={openEvent} className="button button-large">
              Change image
            </Button>
            <Button
              onClick={() => {
                const styles = { ...attributes.componentStyles };
                styles.backgroundImage = null;
                setAttributes({
                  bgImageID: 0,
                  componentStyles: styles,
                });
              }}
              className="button button-large"
            >
              Remove Image
            </Button>
          </div>
        );
      } else {
        return (
          <div className="img-container">
            <Button onClick={openEvent} className="button button-large">
              Pick an image
            </Button>
          </div>
        );
      }
    };

    return [
      <InspectorControls>
        <PanelColorSettings
          title="Color Settings"
          colorSettings={[
            {
              value: attributes.componentStyles.backgroundColor,
              onChange: (colorValue) => {
                const styles = { ...attributes.componentStyles };
                styles.backgroundColor = colorValue;
                setAttributes({ componentStyles: styles });
              },
              label: "Background Color",
            },
            {
              value: attributes.componentStyles.color,
              onChange: (colorValue) => {
                const styles = { ...attributes.componentStyles };
                styles.color = colorValue;
                setAttributes({ componentStyles: styles });
              },
              label: "Text Color",
            },
          ]}
        />
      </InspectorControls>,
      <section className="container">
        <div
          className="nhsm-cta-collections"
          style={attributes.componentStyles}
        >
          <PlainText
            onChange={(content) => setAttributes({ title: content })}
            value={attributes.title}
            placeholder="Call to action title"
            className="nhsm-cta-collections__title"
          />
          <PlainText
            onChange={(content) => setAttributes({ lead: content })}
            value={attributes.lead}
            placeholder="Call to action text"
            className="nhsm-cta-collections__lead"
          />
          <RichText
            tagName="h3"
            className="nhsm-cta-collections__collectionsGridTitle"
            placeholder="The call to action (include link to destination)"
            value={attributes.cta}
            onChange={(content) => setAttributes({ cta: content })}
            multiline={false}
            allowedFormats={["core/link"]}
          />
          <ServerSideRender
            block="nhsm-widgets/collections"
            className="nhsm-cta-collections__collectionsGrid"
            attributes={{
              count: 3,
            }}
          />
          {/*<InnerBlocks allowedBlocks={["nhsm-widgets/collections"]} />*/}
        </div>
        <MediaUpload
          onSelect={(media) => {
            const styles = { ...attributes.componentStyles };
            styles.backgroundImage = "url(" + media.url + ")";
            setAttributes({
              bgImageID: media.id,
              componentStyles: styles,
            });
          }}
          type="image"
          value={attributes.bgImageID}
          render={({ open }) => getImageButton(open)}
        />
      </section>,
    ];
  },
  save({ attributes }) {
    const ctaMarkup = () => {
      let domparser = new DOMParser();
      let cta = domparser.parseFromString(attributes.cta, "text/html");
      let links = cta.getElementsByTagName("a");
      for (let link of links) {
        link.classList.add(
          "button",
          "button--primary",
          "button--prominent",
          "nhsm-cta-collections__button"
        );
      }
      return {
        __html: cta.body.innerHTML,
      };
    };

    return (
      <section
        className="homepage-section nhsm-cta-collections"
        style={attributes.componentStyles}
      >
        <div className="container nhsm-cta-collections__inner">
          <h2 className="nhsm-cta-collections__title">{attributes.title}</h2>
          <p className="nhsm-cta-collections__lead">{attributes.lead}</p>
          <section className="nhsm-cta-collections__collectionGrid">
            <h3
              className="nhsm-cta-collections__collectionsGridTitle"
              dangerouslySetInnerHTML={ctaMarkup()}
            />
            <div id="collections_list"></div>
            {/*<InnerBlocks.Content />*/}
          </section>
        </div>
      </section>
    );
  },
});
