---
title: Contact form
menu: Contact
form:
    name: my-nice-form
    fields:
        - name: name
          label: Name
          placeholder: Enter your name
          type: text
          sizeingrid: uk-width-small-1-2
          classes: uk-width-1-1 uk-form-large
          panelcolor: #8bc34a
          validate:
            required: true

        - name: email
          label: Email
          placeholder: Enter your email address
          type: email
          sizeingrid: uk-width-small-1-2
          classes: uk-width-1-1 uk-form-large
          panelcolor: #9ccc65
          validate:
            rule: email
            required: true

        - name: subject
          label: Subject
          placeholder: Enter your subject
          type: text
          sizeingrid: uk-width-1-1
          classes: uk-width-1-1 uk-form-large
          panelcolor: #aed581
          validate:
            required: true

        - name: message
          label: Message
          size: long
          placeholder: Enter your message
          type: textarea
          rows: 15
          sizeingrid: uk-width-1-1
          classes: uk-width-1-1 uk-form-large
          panelcolor: #c5e1a5
          validate:
            required: true

        - name: g-recaptcha-response
          label: Captcha
          type: captcha
          recaptcha_site_key: 6LdzXRgUAAAAANdBsg7inlNvi_3Stkiw5New5OYC
          recaptcha_not_validated: 'Captcha not valid!'
          sizeingrid: uk-width-1-1
          validate:
            required: true

    buttons:
        - type: submit
          value: <i class="uk-icon-send"></i> Αποστολή
          classes: uk-button uk-button-primary uk-button-large

    process:
        - captcha:
            recaptcha_secret: 6LdzXRgUAAAAAAKxF7rTLvZqysxL7zYdrNCroBb_
        - email:
            from: "{{ config.plugins.email.from }}"
            to: "{{ config.plugins.email.from }}"
            reply_to: "{{ form.value.email }}"
            subject: "[Contact Form] {{ form.value.subject|e }}"
            body: "{% include 'forms/data.html.twig' %}"
        - save:
            fileprefix: feedback-
            dateformat: Ymd-His-u
            extension: txt
            body: "{% include 'forms/data.txt.twig' %}"
        - message: Ευχαριστώ για τα καλά σου λόγια. Παρακάτω βλέπεις όσα μου έγραψες, για να σιγουρευτείς ότι δεν ξέχασες τίποτα.
        - display: thankyou
---