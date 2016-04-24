<?php

class ARIA_Resend_Email {

  public static function aria_create_resend_teacher_email_form() {
    // don't create form if it already exists
    if (ARIA_API::aria_get_resend_email_form_id() !== -1) {
      return;
    }

    // create the new competition form and generate the field mappings
    $form = new GF_Form(RESEND_TEACHER_EMAIL_FORM_NAME, "");
    $field_mappings = self::resend_teacher_field_id_array();

    $competition_name_select_field = new GF_Field_Select();
    $competition_name_select_field->label = "Competition";
    $competition_name_select_field->id = $field_id_arr['competition_name'];
    $competition_name_select_field->isRequired = true;
    $competition_name_select_field->choices = array();
    $form->fields[] = $competition_name_select_field;

    $teacher_field = new GF_Field_Select();
    $teacher_field->label = "Teacher";
    $teacher_field->id = $field_id_arr['teacher'];
    $teacher_field->isRequired = true;
    $teacher_field->choices = array();
    $form->fields[] = $teacher_field;

    $student_field = new GF_Field_Select();
    $student_field->label = "Student";
    $student_field->id = $field_id_arr['student'];
    $student_field->isRequired = true;
    $student_field->choices = array();
    $form->fields[] = $student_field;

    // festival chairmans Email
    $email_field = new GF_Field_Email();
    $email_field->label = "Email";
    $email_field->id = $field_mappings['email'];
    $email_field->description = "Please enter the email address that you";
    $email_field->description .= " wish to send the regestration link to.";
    $email_field->descriptionPlacement = "above";
    $email_field->isRequired = true;
    $form->fields[] = $email_field;

    $successful_submission_message = 'Congratulations! Your request has been sent';
    $form->confirmation['type'] = 'message';
    $form->confirmation['message'] = $successful_submission_message;

    $form_array = $form->createFormArray();
    $form_array['isResendEmailForm'] = true;

    // add the new form to the festival chairman's dashboard
    $new_form_id = GFAPI::add_form($form_array);

    // make sure the new form was added without error
    if (is_wp_error($new_form_id)) {
      wp_die($new_form_id->get_error_message());
    } else {
      // publish this form so it can be used on the front end
      ARIA_API::aria_publish_form(RESEND_TEACHER_EMAIL_FORM_NAME, $new_form_id, CHAIRMAN_PASS, true);
    }
  }

  public static function resend_teacher_field_id_array() {
    return array (
      'competition_name' => 1,
      'teacher' => 2,
      'student' => 3,
      'email' => 4
  );
  }


}