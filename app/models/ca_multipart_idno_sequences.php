<?php
/** ---------------------------------------------------------------------
 * app/models/ca_multipart_idno_sequences.php : table access class for table ca_multipart_idno_sequences
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2010 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This source code is free and modifiable under the terms of
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * @package CollectiveAccess
 * @subpackage models
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 /**
   *
   */


BaseModel::$s_ca_models_definitions['ca_multipart_idno_sequences'] = array(
    'NAME_SINGULAR' 	=> _t('multipart ID numbering sequence'),
    'NAME_PLURAL' 		=> _t('multipart ID numbering sequences'),
    'FIELDS' 			=> array(
        'idno_stub' => array(
                'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD,
                'DISPLAY_WIDTH' => 255, 'DISPLAY_HEIGHT' => 1,
                'IS_NULL' => false,
                'DEFAULT' => '',
                'LABEL' => 'Identifer stub', 'DESCRIPTION' => 'Stub of identifier to use as basis of sequence (eg. if you are generating accession numbers 2008.004.001, 2008.004.002, 2008.004.003, etc. then the stub value is 2008.004)',
                'BOUNDS_LENGTH' => array(0,255)
        ),
        'format' => array(
                'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD,
                'DISPLAY_WIDTH' => 100, 'DISPLAY_HEIGHT' => 1,
                'IS_NULL' => false,
                'DEFAULT' => '',
                'LABEL' => 'Format', 'DESCRIPTION' => 'Format of sequence',
                'BOUNDS_LENGTH' => array(0,100)
        ),
        'element' => array(
                'FIELD_TYPE' => FT_TEXT, 'DISPLAY_TYPE' => DT_FIELD,
                'DISPLAY_WIDTH' => 100, 'DISPLAY_HEIGHT' => 1,
                'IS_NULL' => false,
                'DEFAULT' => '',
                'LABEL' => 'Element', 'DESCRIPTION' => 'Element to use as sequence',
                'BOUNDS_LENGTH' => array(0,100)
        ),
        'seq' => array(
                'FIELD_TYPE' => FT_NUMBER, 'DISPLAY_TYPE' => DT_FIELD,
                'DISPLAY_WIDTH' => 10, 'DISPLAY_HEIGHT' => 1,
                'IS_NULL' => false,
                'DEFAULT' => '',
                'LABEL' => 'Sequence number', 'DESCRIPTION' => 'The next sequence number to use'
        )
    )
);
class ca_multipart_idno_sequences extends BaseModel
{
    # ---------------------------------
    # --- Object attribute properties
    # ---------------------------------
    # Describe structure of content object's properties - eg. database fields and their
    # associated types, what modes are supported, et al.
    #

    # ------------------------------------------------------
    # --- Basic object parameters
    # ------------------------------------------------------
    # what table does this class represent?
    protected $TABLE = 'ca_multipart_idno_sequences';
          
    # what is the primary key of the table?
    protected $PRIMARY_KEY = 'element';

    # ------------------------------------------------------
    # --- Properties used by standard editing scripts
    #
    # These class properties allow generic scripts to properly display
    # records from the table represented by this class
    #
    # ------------------------------------------------------

    # Array of fields to display in a listing of records from this table
    protected $LIST_FIELDS = array('idno_stub');

    # When the list of "list fields" above contains more than one field,
    # the LIST_DELIMITER text is displayed between fields as a delimiter.
    # This is typically a comma or space, but can be any string you like
    protected $LIST_DELIMITER = ' ';

    # What you'd call a single record from this table (eg. a "person")
    protected $NAME_SINGULAR;

    # What you'd call more than one record from this table (eg. "people")
    protected $NAME_PLURAL;

    # List of fields to sort listing of records by; you can use
    # SQL 'ASC' and 'DESC' here if you like.
    protected $ORDER_BY = array('idno_stub');

    # Maximum number of record to display per page in a listing
    protected $MAX_RECORDS_PER_PAGE = 20;

    # How do you want to page through records in a listing: by number pages ordered
    # according to your setting above? Or alphabetically by the letters of the first
    # LIST_FIELD?
    protected $PAGE_SCHEME = 'alpha'; # alpha [alphabetical] or num [numbered pages; default]

    # If you want to order records arbitrarily, add a numeric field to the table and place
    # its name here. The generic list scripts can then use it to order table records.
    protected $RANK = '';
    
    
    # ------------------------------------------------------
    # Hierarchical table properties
    # ------------------------------------------------------
    protected $HIERARCHY_TYPE				=	null;
    protected $HIERARCHY_LEFT_INDEX_FLD 	= 	null;
    protected $HIERARCHY_RIGHT_INDEX_FLD 	= 	null;
    protected $HIERARCHY_PARENT_ID_FLD		=	null;
    protected $HIERARCHY_DEFINITION_TABLE	=	null;
    protected $HIERARCHY_ID_FLD				=	null;
    protected $HIERARCHY_POLY_TABLE			=	null;
    
    # ------------------------------------------------------
    # Change logging
    # ------------------------------------------------------
    protected $UNIT_ID_FIELD = null;
    protected $LOG_CHANGES_TO_SELF = false;
    protected $LOG_CHANGES_USING_AS_SUBJECT = array(
        "FOREIGN_KEYS" => array(
        
        ),
        "RELATED_TABLES" => array(
        
        )
    );
    # ------------------------------------------------------
    # $FIELDS contains information about each field in the table. The order in which the fields
    # are listed here is the order in which they will be returned using getFields()

    protected $FIELDS;
    
    # ------------------------------------------------------
    # --- Constructor
    #
    # This is a function called when a new instance of this object is created. This
    # standard constructor supports three calling modes:
    #
    # 1. If called without parameters, simply creates a new, empty objects object
    # 2. If called with a single, valid primary key value, creates a new objects object and loads
    #    the record identified by the primary key value
    #
    # ------------------------------------------------------
    public function __construct($pn_id=null)
    {
        parent::__construct($pn_id);	# call superclass constructor
    }
    # ------------------------------------------------------
}
