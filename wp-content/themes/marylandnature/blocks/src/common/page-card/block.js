const {
  InspectorControls,
  MediaUpload,
  PlainText,
  RichText,
  URLInput,
  URLInputButton,
} = wp.blockEditor;
const { registerBlockType } = wp.blocks;
const { Button, PanelBody, TextControl } = wp.components;

//import "./style.scss"; //unneeded, all styling from cards.scss in theme
import "./editor.scss";

registerBlockType("nhsm-common/page-card", {
  title: "Page Card",
  icon: "index-card",
  category: "common",
  attributes: {
    title: {
      source: "text",
      type: "string",
      selector: ".pageCard__title",
    },
    url: {
      source: "attribute",
      attribute: "href",
      type: "string",
      selector: ".pageCard__link",
    },
    body: {
      source: "children",
      type: "array",
      selector: ".pageCard__excerpt",
    },
    image: {
      type: "object",
      url: {
        type: "string",
        source: "attribute",
        attribute: "src",
        selector: ".pageCard__img",
      },
      alt: {
        type: "string",
        source: "attribute",
        attribute: "alt",
        selector: ".pageCard__img",
        default: "",
      },
      width: {
        type: "integer",
        source: "attribute",
        attribute: "width",
        selector: ".pageCard__img",
      },
      height: {
        type: "integer",
        source: "attribute",
        attribute: "height",
        selector: ".pageCard__img",
      },
    },
    imageCaption: {
      type: "string",
      source: "meta",
      meta: "source_credit",
    },
    imageID: {
      type: "integer",
    },
    targetPost: {
      type: "integer",
      default: 0,
    },
  },
  edit({ attributes, className, setAttributes }) {
    const getImageButton = (openEvent) => {
      if (attributes.image) {
        return <img src={attributes.image.url} onClick={openEvent} />;
      } else {
        return (
          <div className="button-container">
            <Button onClick={openEvent} className="button button-large">
              Pick an image
            </Button>
          </div>
        );
      }
    };

    return [
      attributes.targetPost && (
        <InspectorControls>
          <PanelBody title="Card Settings">
            Card destination: {attributes.url}
          </PanelBody>
        </InspectorControls>
      ),
      <div>
        {!attributes.targetPost ? (
          <article className="pageCard">
            <h2>Select a page to initiate a new card</h2>
            <URLInputButton
              url={attributes.url}
              onChange={(url, post) => {
                let attrs = {};
                attrs.url = url;
                if (post) {
                  attrs.targetPost = post.id;
                  attrs.title = post.title;
                }
                setAttributes(attrs);
              }}
            />
          </article>
        ) : (
          <article className="pageCard">
            <header className="pageCard__header">
              <MediaUpload
                onSelect={(media) => {
                  setAttributes({
                    image: {
                      url: media.sizes.nhsm_medium4x3.url,
                      alt: media.alt,
                      width: media.sizes.nhsm_medium4x3.width,
                      height: media.sizes.nhsm_medium4x3.height,
                    },
                    imageID: media.id,
                  });
                }}
                type="image"
                value={attributes.imageID}
                render={({ open }) => getImageButton(open)}
              />

              <div className="nhsm-cta-newsletter-signup__buttonEditor">
                <PlainText
                  onChange={(content) => setAttributes({ title: content })}
                  value={attributes.title}
                  placeholder="Your card title"
                  className="pageCard__title"
                />
                <URLInputButton
                  url={attributes.url}
                  onChange={(url) => setAttributes({ url: url })}
                />
              </div>
            </header>
            <RichText
              onChange={(content) => setAttributes({ body: content })}
              value={attributes.body}
              multiline="p"
              placeholder="Your card text"
            />
          </article>
        )}
      </div>,
    ];
  },
  save({ attributes }) {
    const image = (image, imageID) => {
      if (!image) return null;
      const classList = "img-responsive wp-image-" + imageID;

      if (image.alt !== "") {
        return (
          <img
            src={image.url}
            width={image.width}
            height={image.height}
            alt={image.alt}
            className={classList}
          />
        );
      }

      // No alt set, so let's hide it from screen readers
      return (
        <img
          src={image.url}
          width={image.width}
          height={image.height}
          alt=""
          aria-hidden="true"
          className={classList}
        />
      );
    };

    return (
      <article className="pageCard">
        <header className="pageCard__header">
          <h1 className="pageCard__title">
            <a className="pageCard__link" href={attributes.url}>
              {attributes.title}
            </a>
          </h1>
          <figure className="figure figure--captionOverlay pageCard__figure">
            {image(attributes.image, attributes.imageID)}
            <figcaption></figcaption>
          </figure>
        </header>
        <div className="pageCard__excerpt">{attributes.body}</div>
      </article>
    );
  },
});
