const {
  InspectorControls,
  MediaUpload,
  PlainText,
  URLInputButton,
} = wp.blockEditor;
const { registerBlockType } = wp.blocks;
const { Button, PanelBody, TextareaControl, ExternalLink } = wp.components;

import "./style.scss";
import "./editor.scss";

registerBlockType("nhsm-featurettes/newsletter-signup", {
  title: "Newsletter Signup",
  icon: "email-alt",
  category: "nhsm-featurettes",
  attributes: {
    title: {
      source: "text",
      selector: ".nhsm-cta-newsletter-signup__title",
    },
    body: {
      source: "text",
      selector: ".nhsm-cta-newsletter-signup__body",
    },
    linkText: {
      type: "string",
      source: "text",
      selector: ".nhsm-cta-newsletter-signup__buttonText",
    },
    linkURL: {
      type: "string",
      source: "attribute",
      attribute: "href",
      selector: ".nhsm-cta-newsletter-signup__button",
      default: "#",
    },
    image: {
      type: "object",
      url: {
        type: "string",
        source: "attribute",
        attribute: "src",
        selector: ".nhsm-cta-newsletter-signup__figure img",
      },
      alt: {
        type: "string",
        source: "attribute",
        attribute: "alt",
        selector: ".nhsm-cta-newsletter-signup__figure img",
        default: "",
      },
      width: {
        type: "integer",
        source: "attribute",
        attribute: "width",
        selector: ".nhsm-cta-newsletter-signup__figure img",
      },
      height: {
        type: "integer",
        source: "attribute",
        attribute: "height",
        selector: ".nhsm-cta-newsletter-signup__figure img",
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
  },
  edit({ attributes, className, setAttributes }) {
    const getImageButton = (openEvent) => {
      if (attributes.image.url) {
        return (
          <img
            src={attributes.image.url}
            onClick={openEvent}
            className="nhsm-cta-newsletter-signup__image"
          />
        );
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
      attributes.imageID && (
        <InspectorControls>
          <PanelBody title="Image Settings">
            <TextareaControl
              label="Alt text (alternative text)"
              value={attributes.image.alt}
              onChange={(alt) => {
                const image = { ...attributes.image };
                image.alt = alt;
                setAttributes({ image: image });
              }}
              help={
                <div>
                  <ExternalLink href="https://www.w3.org/WAI/tutorials/images/decision-tree">
                    Describe the purpose of the image
                  </ExternalLink>
                  Leave empty if the image is purely decorative.
                </div>
              }
            />
          </PanelBody>
        </InspectorControls>
      ),
      <div className="container nhsm-cta-newsletter-signup">
        <PlainText
          onChange={(content) => setAttributes({ title: content })}
          value={attributes.title}
          placeholder="Your card title"
          className="nhsm-cta-newsletter-signup__title"
        />
        <PlainText
          onChange={(content) => setAttributes({ body: content })}
          value={attributes.body}
          placeholder="Your card text"
          className="nhsm-cta-newsletter-signup__body"
        />
        <section className="nhsm-cta-newsletter-signup__buttonEditor">
          <PlainText
            onChange={(content) => setAttributes({ linkText: content })}
            value={attributes.linkText}
            placeholder="Button text"
            className="nhsm-cta-newsletter-signup__buttonText"
          />
          <URLInputButton
            url={attributes.linkURL}
            onChange={(url, post) => setAttributes({ linkURL: url })}
          />
        </section>
        <MediaUpload
          onSelect={(media) => {
            setAttributes({
              image: {
                url: media.sizes.nhsm_headshot.url,
                alt: media.alt,
                width: media.sizes.nhsm_headshot.width,
                height: media.sizes.nhsm_headshot.height,
              },
              imageID: media.id,
            });
          }}
          type="image"
          value={attributes.imageID}
          render={({ open }) => getImageButton(open)}
        />
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
      <section className="homepage-section nhsm-cta-newsletter-signup">
        <div className="container nhsm-cta-newsletter-signup__inner">
          <h2 className="nhsm-cta-newsletter-signup__title">
            {attributes.title}
          </h2>
          <p className="nhsm-cta-newsletter-signup__body">{attributes.body}</p>
          <a
            href={attributes.linkURL}
            className="button button--primary button--prominent nhsm-cta-newsletter-signup__button iconButton--iconFirst iconButton--grow"
          >
            <i className="fas fa-paper-plane"></i>
            <span className="nhsm-cta-newsletter-signup__buttonText">
              {attributes.linkText}
            </span>
          </a>
          <div className="nhsm-cta-newsletter-signup__figure">
            <figure className="figure figure--captionOverlay figure--circle">
              {image(attributes.image, attributes.imageID)}
              <figcaption></figcaption>
            </figure>
          </div>
        </div>
      </section>
    );
  },
});
