const { PlainText, URLInput, URLInputButton } = wp.blockEditor;
const { registerBlockType } = wp.blocks;
const { Button, PanelBody, TextControl } = wp.components;

import "./style.scss";
import "./editor.scss";

registerBlockType("nhsm-common/contact", {
  title: "Contact Details",
  icon: "phone",
  category: "common",
  attributes: {
    email: {
      source: "text",
      type: "string",
      selector: ".nhsm-contact__email",
    },
    emailLink: {
      source: "attribute",
      attribute: "href",
      type: "string",
      selector: ".nhsm-contact__email",
    },
    phone: {
      source: "text",
      type: "string",
      selector: ".nhsm-contact__phone",
    },
    phoneLink: {
      source: "attribute",
      attribute: "href",
      type: "string",
      selector: ".nhsm-contact__phone",
    },
    address: {
      source: "text",
      type: "string",
      selector: ".nhsm-contact__address",
    },
    addressLink: {
      source: "attribute",
      attribute: "href",
      type: "string",
      selector: ".nhsm-contact__address",
    },
  },
  edit({ attributes, className, setAttributes }) {
    return (
      <div className="container nhsm-contact">
        <div className="nhsm-contact__group">
          <PlainText
            className="nhsm-contact__email"
            value={attributes.email}
            onChange={(content) => setAttributes({ email: content })}
            placeholder="Email Address"
          />
          {attributes.email && (
            <URLInputButton
              url={attributes.emailLink}
              onChange={(url) => setAttributes({ emailLink: url })}
              disableSuggestions={true}
            />
          )}
        </div>
        <div className="nhsm-contact__group">
          <PlainText
            className="nhsm-contact__phone"
            value={attributes.phone}
            onChange={(content) => setAttributes({ phone: content })}
            placeholder="Phone"
          />
          {attributes.phone && (
            <URLInputButton
              url={attributes.phoneLink}
              onChange={(url) => setAttributes({ phoneLink: url })}
              disableSuggestions={true}
            />
          )}
        </div>
        <div className="nhsm-contact__group">
          <PlainText
            className="nhsm-contact__address"
            value={attributes.address}
            onChange={(content) => setAttributes({ address: content })}
            placeholder="Address"
          />
          {attributes.address && (
            <URLInputButton
              url={attributes.addressLink}
              onChange={(url) => setAttributes({ addressLink: url })}
              disableSuggestions={true}
            />
          )}
        </div>
      </div>
    );
  },
  save({ attributes }) {
    const icon = (iconClass) => {
      return (
        <span className={"icon-round"}>
          <i className={iconClass}></i>
        </span>
      );
    };
    return (
      <ul className="flex-list flex-list--wrap contact-details">
        <li className="flex-list__item">
          <a
            href={attributes.emailLink}
            className="nhsm-contact__email icon-with-text"
          >
            {icon("fas fa-envelope")}
            {attributes.email}
          </a>
        </li>
        <li className="flex-list__item">
          <a
            href={attributes.phoneLink}
            className="nhsm-contact__phone icon-with-text"
          >
            {icon("fas fa-phone")}
            {attributes.phone}
          </a>
        </li>
        <li className="flex-list__item">
          <a
            href={attributes.addressLink}
            className="nhsm-contact__address icon-with-text"
          >
            {icon("fas fa-map-pin")}
            {attributes.address}
          </a>
        </li>
      </ul>
    );
  },
});
