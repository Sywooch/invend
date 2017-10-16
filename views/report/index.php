<?php
        $reportico = \Yii::$app->getModule('reportico');
        $q = $reportico->getReporticoEngine();        // Fetches reportico engine

        $q->access_mode = "ONEREPORT";                // Allows access to single specified report
        $q->initial_output_format = "PDF";
        $q->initial_execute_mode = "PREPARE";         // Starts user in report criteria selection mode
        $q->initial_project = "invend";            // Name of report project folder
        $q->initial_project_password = "Larai@101#"; // If project password required
        $q->initial_report = "invend_summary_report";           // Name of report to run
        $q->bootstrap_styles = "3";                   // Set to "3" for bootstrap v3, "2" for V2 or false for no bootstrap
        $q->force_reportico_mini_maintains = true;    // Often required
        $q->bootstrap_preloaded = true;               // true if you dont need Reportico to load its own bootstrap
        $q->clear_reportico_session = true;           // Normally required

        // Turn on and off UI elements
        $q->output_template_parameters["show_hide_navigation_menu"] = "show";   
        $q->output_template_parameters["show_hide_dropdown_menu"] = "show";
        $q->output_template_parameters["show_hide_report_output_title"] = "hide";
        $q->output_template_parameters["show_hide_prepare_section_boxes"] = "hide";
        $q->output_template_parameters["show_hide_prepare_pdf_button"] = "show";
        $q->output_template_parameters["show_hide_prepare_html_button"] = "hide";
        $q->output_template_parameters["show_hide_prepare_print_html_button"] = "show";
        $q->output_template_parameters["show_hide_prepare_csv_button"] = "hide";
        $q->output_template_parameters["show_hide_prepare_page_style"] = "hide";

        $q->execute();   
?>
