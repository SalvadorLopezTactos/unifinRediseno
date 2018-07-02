/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Views.Base.DnbView
 * @alias SUGAR.App.view.views.BaseDnbView
 * @extends View.View
 */
({
    plugins: ['Dashlet'],
    currentCompany: null,
    //dnb api response codes
    responseCodes: {
        success: 'CM000'
    },
    //common constants
    commonConst: {
        'sic_code': 3599,
        'hoovers_ind_code': 25838,
        'sic_to_hic': 3599,
        'connectorSettingsURL': 'index.php#bwc/index.php?module=Connectors&action=ModifyProperties&active_tab=ext_rest_dnb',
        'systemSettingsURL': 'index.php#bwc/index.php?module=Configurator&action=EditView'
    },

    //mapping of sugar column names to dnb api response
    accountsMap: {
        'name': 'OrganizationName.OrganizationPrimaryName.0.OrganizationName.$', //account name
        'duns_num': 'SubjectHeader.DUNSNumber', //duns_num
        'billing_address_street': 'Location.PrimaryAddress.0.StreetAddressLine.0.LineText',
        'billing_address_city': 'Location.PrimaryAddress.0.PrimaryTownName',
        'billing_address_state': 'Location.PrimaryAddress.0.TerritoryAbbreviatedName',
        'billing_address_country': 'Location.PrimaryAddress.0.CountryISOAlpha2Code',
        'billing_address_postalcode': 'Location.PrimaryAddress.0.PostalCode',
        'website': 'Telecommunication.WebPageAddress.0.TelecommunicationAddress',
        'phone_office': 'Telecommunication.TelephoneNumber.0.TelecommunicationNumber',
        'employees': 'EmployeeFigures.IndividualEntityEmployeeDetails.TotalEmployeeQuantity',
        'annual_revenue': 'Financial.KeyFinancialFiguresOverview.0.SalesRevenueAmount.0.$',
        'ownership': 'OrganizationDetail.ControlOwnershipTypeText.$',
        'sic_code': 'primarySIC.IndustryCode.$'
    },
    //D&B Firmographic API product codes
    compInfoProdCD: {
        'lite': 'DCP_BAS',
        'std': 'DCP_STD',
        'prem': 'DCP_PREM'
    },

    /**
     * json_path -- refers to the json path to traverse to obtain the data element
     * label -- refers to the label to be used to name the data element
     * desc -- refers to the label used to describe the data element
     * case_fmt -- boolean -- when true specifies that this data element needs to be formatted to proper case
     * sub_array -- refers to meta data for nested json objects
     */
    compinfoDD: {
        'compname': {
            'json_path': 'OrganizationName.OrganizationPrimaryName.0.OrganizationName.$',
            'label': 'LBL_DNB_PRIM_NAME',
            'desc': 'LBL_DNB_PRIM_NAME_DESC',
            'case_fmt': true
        },
        'tradename': {
            'json_path': 'OrganizationName.TradeStyleName.0.OrganizationName.$',
            'label': 'LBL_DNB_TRD_NAME',
            'desc': 'LBL_DNB_TRD_NAME_DESC',
            'case_fmt': true
        },
        'locationtype': {
            'json_path': 'OrganizationDetail.FamilyTreeMemberRole.0.FamilyTreeMemberRoleText.$',
            'label': 'LBL_DNB_LOCATION_TYPE',
            'desc': 'LBL_DNB_LOCATION_TYPE_DESC',
            'case_fmt': true
        },
        'cntrowndate': {
            'json_path': 'OrganizationDetail.ControlOwnershipDate.$',
            'label': 'LBL_DNB_CNTRL_OWN_DATE',
            'desc': 'LBL_DNB_CNTRL_OWN_DATE_DESC'
        },
        'cntrowntype': {
            'json_path': 'OrganizationDetail.ControlOwnershipTypeText.$',
            'label': 'LBL_DNB_CNTRL_TYP_TEXT',
            'desc': 'LBL_DNB_CNTRL_TYP_TEXT_DESC',
            'case_fmt': true
        },
        'operstatus': {
            'json_path': 'OrganizationDetail.OperatingStatusText.$',
            'label': 'LBL_DNB_OPERL_STA_TEXT',
            'desc': 'LBL_DNB_OPERL_STA_TEXT_DESC',
            'case_fmt': true
        },
        'boneyardind': {
            'json_path': 'OrganizationDetail.BoneyardOrganizationIndicator',
            'label': 'LBL_DNB_BONE_ORG_IND',
            'desc': 'LBL_DNB_BONE_ORG_IND_DESC'
        },
        'orgstartyear': {
            'json_path': 'OrganizationDetail.OrganizationStartYear',
            'label': 'LBL_DNB_ORGS_STRT_YEAR',
            'desc': 'LBL_DNB_ORGS_STRT_YEAR_DESC'
        },
        'francoper': {
            'json_path': 'OrganizationDetail.FranchiseOperationTypeText.$',
            'label': 'LBL_DNB_FRAN_TYP_TEXT',
            'desc': 'LBL_DNB_FRAN_TYP_TEXT_DESC',
            'case_fmt': true
        },
        'primaddrstreet': {
            'json_path': 'Location.PrimaryAddress.0.StreetAddressLine.0.LineText',
            'label': 'LBL_DNB_PRIM_STREET',
            'desc': 'LBL_DNB_PRIM_STREET_DESC',
            'case_fmt': true
        },
        'primaddrcity': {
            'json_path': 'Location.PrimaryAddress.0.PrimaryTownName',
            'label': 'LBL_DNB_PRIM_CITY',
            'desc': 'LBL_DNB_PRIM_CITY_DESC',
            'case_fmt': true
        },
        'primaddrstateabbr': {
            'json_path': 'Location.PrimaryAddress.0.TerritoryAbbreviatedName',
            'label': 'LBL_DNB_PRIM_STATE_ABBR',
            'desc': 'LBL_DNB_PRIM_STATE_ABBR_DESC'
        },
        'primaddrstate': {
            'json_path': 'Location.PrimaryAddress.0.TerritoryOfficialName',
            'label': 'LBL_DNB_PRIM_STATE',
            'desc': 'LBL_DNB_PRIM_STATE_DESC'
        },
        'primaddrctrycd': {
            'json_path': 'Location.PrimaryAddress.0.CountryISOAlpha2Code',
            'label': 'LBL_DNB_PRIM_CTRY_CD',
            'desc': 'LBL_DNB_PRIM_CTRY_CD_DESC'
        },
        'primaddrctrygrp': {
            'json_path': 'Location.PrimaryAddress.0.CountryGroupName',
            'label': 'LBL_DNB_PRIM_CTRY_GRP',
            'desc': 'LBL_DNB_PRIM_CTRY_GRP_DESC'
        },
        'primaddrzip': {
            'json_path': 'Location.PrimaryAddress.0.PostalCode',
            'label': 'LBL_DNB_PRIM_ZIP',
            'desc': 'LBL_DNB_PRIM_ZIP_DESC'
        },
        'primaddrcountyname': {
            'json_path': 'Location.PrimaryAddress.0.CountyOfficialName',
            'label': 'LBL_DNB_PRIM_COUNTY_NAME',
            'desc': 'LBL_DNB_PRIM_COUNTY_NAME_DESC'
        },
        'uscensuscd': {
            'json_path': 'Location.PrimaryAddress.0.MetropolitanStatisticalAreaUSCensusCode.0',
            'label': 'LBL_DNB_PRIM_CEN_CD',
            'desc': 'LBL_DNB_PRIM_CEN_CD_DESC'
        },
        'mailingaddrstreet': {
            'json_path': 'Location.MailingAddress.0.StreetAddressLine.0.LineText',
            'label': 'LBL_DNB_MAIL_STREET',
            'desc': 'LBL_DNB_PRIM_STREET_DESC',
            'case_fmt': true
        },
        'mailingaddrcity': {
            'json_path': 'Location.MailingAddress.0.PrimaryTownName',
            'label': 'LBL_DNB_MAIL_CITY',
            'desc': 'LBL_DNB_PRIM_CITY_DESC',
            'case_fmt': true
        },
        'mailingaddrstateabbr': {
            'json_path': 'Location.MailingAddress.0.TerritoryAbbreviatedName',
            'label': 'LBL_DNB_MAIL_STATE_ABBR',
            'desc': 'LBL_DNB_PRIM_STATE_ABBR_DESC'
        },
        'mailingaddrzip': {
            'json_path': 'Location.MailingAddress.0.PostalCode',
            'label': 'LBL_DNB_MAIL_ZIP',
            'desc': 'LBL_DNB_PRIM_ZIP_DESC'
        },
        'mailingaddrctrycd': {
            'json_path': 'Location.MailingAddress.0.CountryISOAlpha2Code',
            'label': 'LBL_DNB_MAIL_CTRY_CD',
            'desc': 'LBL_DNB_PRIM_CTRY_CD_DESC'
        },
        'long': {
            'json_path': 'Location.PrimaryAddress.0.LongitudeMeasurement',
            'label': 'LBL_DNB_LAT',
            'desc': 'LBL_DNB_LAT_DESC'
        },
        'lat': {
            'json_path': 'Location.PrimaryAddress.0.LatitudeMeasurement',
            'label': 'LBL_DNB_LONG',
            'desc': 'LBL_DNB_LONG_DESC'
        },
        'phone': {
            'json_path': 'Telecommunication.TelephoneNumber.0',
            'desc': 'LBL_DNB_PHONE_DESC',
            'sub_object': {
                'data_type': 'phone_idc',
                'data_name': 'phone_office',
                'phone_no': 'TelecommunicationNumber',
                'id_code': 'InternationalDialingCode',
                'label': 'LBL_DNB_PHONE'
            }
        },
        'fax': {
            'json_path': 'Telecommunication.FacsimileNumber.0',
            'desc': 'LBL_DNB_FAX_DESC',
            'sub_object': {
                'data_type': 'phone_idc',
                'data_name': 'fax',
                'phone_no': 'TelecommunicationNumber',
                'id_code': 'InternationalDialingCode',
                'label': 'LBL_DNB_FAX'
            }
        },
        'webpage': {
            'json_path': 'Telecommunication.WebPageAddress.0.TelecommunicationAddress',
            'label': 'LBL_DNB_WEBPAGE',
            'desc': 'LBL_DNB_WEBPAGE_DESC',
            'type': 'link'
        },
        'indempcnt': {
            'json_path': 'EmployeeFigures.IndividualEntityEmployeeDetails.TotalEmployeeQuantity',
            'label': 'LBL_DNB_IND_EMP_CNT',
            'desc': 'LBL_DNB_IND_EMP_CNT_DESC'
        },
        'conempcnt': {
            'json_path': 'EmployeeFigures.ConsolidatedEmployeeDetails.TotalEmployeeQuantity',
            'label': 'LBL_DNB_CON_EMP_CNT',
            'desc': 'LBL_DNB_CON_EMP_CNT_DESC'
        },
        'empdet': {
            'json_path': 'PrincipalsAndManagement.CurrentPrincipal',
            'label': 'LBL_DNB_EMP_DET',
            'desc': 'LBL_DNB_EMP_DET_DESC',
            'sub_array': {
                'data_type': 'emp_det',
                'job_title': 'JobTitle.0.JobTitleText.$',
                'full_name': 'PrincipalName.FullName'
            }
        },
        'lob': {
            'json_path': 'ActivitiesAndOperations.LineOfBusinessDetails.0.LineOfBusinessDescription.$',
            'label': 'LBL_DNB_LOB',
            'desc': 'LBL_DNB_LOB_DESC'
        },
        'impind': {
            'json_path': 'ActivitiesAndOperations.ImportDetails.ImportIndicator',
            'label': 'LBL_DNB_IMP_IND',
            'desc': 'LBL_DNB_IMP_IND_DESC'
        },
        'expind': {
            'json_path': 'ActivitiesAndOperations.ExportDetails.ExportIndicator',
            'label': 'LBL_DNB_EXP_IND',
            'desc': 'LBL_DNB_EXP_IND_DESC'
        },
        'agentind': {
            'json_path': 'ActivitiesAndOperations.SubjectIsAgentDetails.AgentIndicator',
            'label': 'LBL_DNB_AGENT_IND',
            'desc': 'LBL_DNB_AGENT_IND_DESC'
        },
        'opertext': {
            'json_path': 'ActivitiesAndOperations.OperationsText.0',
            'label': 'LBL_DNB_OPER_TEXT',
            'desc': 'LBL_DNB_OPER_TEXT_DESC'
        },
        'histrat': {
            'json_path': 'Assessment.HistoryRatingText.$',
            'label': 'LBL_DNB_HIST_RAT',
            'desc': 'LBL_DNB_HIST_RAT_DESC'
        },
        'ccs': {
            'json_path': 'Assessment.CommercialCreditScore.0.MarketingRiskClassText.$',
            'label': 'LBL_DNB_CCS',
            'desc': 'LBL_DNB_CCS_DESC'
        },
        'uspatriskscr': {
            'json_path': 'Assessment.USPatriotActComplianceRiskScore.ComplianceRiskIndex',
            'label': 'LBL_DNB_USPAT_SCR',
            'desc': 'LBL_DNB_USPAT_SCR_DESC'
        },
        'tpa': {
            'json_path': 'ThirdPartyAssessment.ThirdPartyAssessment',
            'label': 'LBL_DNB_TPA',
            'desc': 'LBL_DNB_TPA_DESC',
            'sub_array': {
                'assmt_type': 'AssessmentTypeValue',
                'assmt': 'AssessmentValue',
                'data_type': 'tpa'
            }
        },
        'minind': {
            'json_path': 'SocioEconomicIdentification.MinorityOwnedIndicator',
            'label': 'LBL_DNB_MIN_IND',
            'desc': 'LBL_DNB_MIN_IND_DESC'
        },
        'smbind': {
            'json_path': 'SocioEconomicIdentification.SmallBusinessIndicator',
            'label': 'LBL_DNB_SMB_IND',
            'desc': 'LBL_DNB_SMB_IND_DESC'
        },
        'ethn': {
            'json_path': 'SocioEconomicIdentification.OwnershipEthnicity.0.EthnicityTypeText.$',
            'label': 'LBL_DNB_ETHN',
            'desc': 'LBL_DNB_ETHN_DESC',
            'case_fmt': true
        },
        'femind': {
            'json_path': 'SocioEconomicIdentification.FemaleOwnedIndicator',
            'label': 'LBL_DNB_FEM_IND',
            'desc': 'LBL_DNB_FEM_IND_DESC'
        },
        'smbdisadv': {
            'json_path': 'SocioEconomicIdentification.SmallDisadvantagedBusinessIndicator',
            'label': 'LBL_DNB_SMBDISADV_IND',
            'desc': 'LBL_DNB_SMBDISADV_IND_DESC'
        },
        'alasnat': {
            'json_path': 'SocioEconomicIdentification.AlaskanNativeCorporationIndicator',
            'label': 'LBL_DNB_ALASNAT_IND',
            'desc': 'LBL_DNB_ALASNAT_IND_DESC'
        },
        'smbcert': {
            'json_path': 'SocioEconomicIdentification.CertifiedSmallBusinessIndicator',
            'label': 'LBL_DNB_SMB_CERT',
            'desc': 'LBL_DNB_SMB_CERT_DESC'
        },
        'mincoll': {
            'json_path': 'SocioEconomicIdentification.MinorityCollegeIndicator',
            'label': 'LBL_DNB_MIN_COLL',
            'desc': 'LBL_DNB_MIN_COLL_DESC'
        },
        'disab': {
            'json_path': 'SocioEconomicIdentification.DisabledOwnedIndicator',
            'label': 'LBL_DNB_DISAB_IND',
            'desc': 'LBL_DNB_DISAB_IND_DESC'
        },
        'svcdisabvet': {
            'json_path': 'SocioEconomicIdentification.ServiceDisabledVeteranOwnedIndicator',
            'label': 'LBL_DNB_SVC_DISAB_VET',
            'desc': 'LBL_DNB_SVC_DISAB_VET_DESC'
        },
        'vietvet': {
            'json_path': 'SocioEconomicIdentification.VietnamVeteranOwnedIndicator',
            'label': 'LBL_DNB_VIET_VET',
            'desc': 'LBL_DNB_VIET_VET_DESC'
        },
        'airprtdisadvent': {
            'json_path': 'SocioEconomicIdentification.AirportConcessionDisadvantagedBusinessEnterpriseIndicator',
            'label': 'LBL_DNB_AIRPRT_DISADV_ENT',
            'desc': 'LBL_DNB_AIRPRT_DISADV_ENT_DESC'
        },
        'disabvetent': {
            'json_path': 'SocioEconomicIdentification.DisabledVeteranBusinessEnterpriseIndicator',
            'label': 'LBL_DNB_DISAB_VET_ENT',
            'desc': 'LBL_DNB_DISAB_VET_ENT_DESC'
        },
        'disadvent': {
            'json_path': 'SocioEconomicIdentification.DisadvantagedBusinessEnterpriseIndicator',
            'label': 'LBL_DNB_DISADV_ENT',
            'desc': 'LBL_DNB_DISADV_ENT_DESC'
        },
        'disadvvetent': {
            'json_path': 'SocioEconomicIdentification.DisadvantagedVeteranEnterpriseIndicator',
            'label': 'LBL_DNB_DISADV_VET_ENT',
            'desc': 'LBL_DNB_DISADV_VET_ENT_DESC'
        },
        'minent': {
            'json_path': 'SocioEconomicIdentification.MinorityBusinessEnterpriseIndicator',
            'label': 'LBL_DNB_MIN_ENT',
            'desc': 'LBL_DNB_MIN_ENT_DESC'
        },
        'fement': {
            'json_path': 'SocioEconomicIdentification.FemaleOwnedBusinessEnterpriseIndicator',
            'label': 'LBL_DNB_FEM_ENT',
            'desc': 'LBL_DNB_FEM_ENT_DESC'
        },
        'hubcrt': {
            'json_path': 'SocioEconomicIdentification.HUBZoneCertifiedBusinessIndicator',
            'label': 'LBL_DNB_HUB_CRT',
            'desc': 'LBL_DNB_HUB_CRT_DESC'
        },
        'eightacrt': {
            'json_path': 'SocioEconomicIdentification.EightACertifiedBusinessIndicator',
            'label': 'LBL_DNB_EIGHTA_CRT',
            'desc': 'LBL_DNB_EIGHTA_CRT_DESC'
        },
        'vet_ind': {
            'json_path': 'SocioEconomicIdentification.VeteranOwnedIndicator',
            'label': 'LBL_DNB_VET_IND',
            'desc': 'LBL_DNB_VET_IND_DESC'
        },
        'lsind': {
            'json_path': 'SocioEconomicIdentification.LaborSurplusAreaIndicator',
            'label': 'LBL_DNB_LS_IND',
            'desc': 'LBL_DNB_LS_IND_DESC'
        },
        'vetent': {
            'json_path': 'SocioEconomicIdentification.VeteranBusinessEnterpriseIndicator',
            'label': 'LBL_DNB_VET_ENT',
            'desc': 'LBL_DNB_VET_ENT_DESC'
        },
        'inqcnt': {
            'json_path': 'SubjectHeader.TotalInquiriesCount',
            'label': 'LBL_DNB_INQ_CNT',
            'desc': 'LBL_DNB_INQ_CNT_DESC'
        },
        'transferdunsnbr': {
            'json_path': 'SubjectHeader.TransferDUNSNumberRegistration.0.TransferredFromDUNSNumber',
            'label': 'LBL_DNB_TRNS_DUNS',
            'desc': 'LBL_DNB_TRNS_DUNS_DESC'
        },
        'lastupddate': {
            'json_path': 'SubjectHeader.LastUpdateDate.$',
            'label': 'LBL_DNB_LAST_UPD_DATE',
            'desc': 'LBL_DNB_LAST_UPD_DATE_DESC'
        },
        'marketind': {
            'json_path': 'SubjectHeader.MarketabilityIndicator',
            'label': 'LBL_DNB_MARKET_IND',
            'desc': 'LBL_DNB_MARKET_IND_DESC'
        },
        'dunsselfind': {
            'json_path': 'SubjectHeader.DUNSSelfRequestIndicator',
            'label': 'LBL_DNB_DUNSSELF_IND',
            'desc': 'LBL_DNB_DUNSSELF_IND_DESC'
        },
        'nonmarkreastxt': {
            'json_path': 'SubjectHeader.NonMarketableReasonText.0.$',
            'label': 'LBL_DNB_NONMARK_REAS_TXT',
            'desc': 'LBL_DNB_NONMARK_REAS_TXT_DESC',
            'case_fmt': true
        },
        'orgid': {
            'json_path': 'RegisteredDetail.OrganizationIdentificationNumberDetail',
            'label': 'LBL_DNB_ORG_ID',
            'desc': 'LBL_DNB_ORG_ID_DESC',
            'sub_array': {
                'data_type': 'org_id',
                'org_id': 'OrganizationIdentificationNumber',
                'org_id_type': '@TypeText'
            }
        },
        'indcodes': {
            'json_path': 'IndustryCode.IndustryCode',
            'label': 'LBL_DNB_IND_CD',
            'desc': 'LBL_DNB_IND_CD_DESC',
            'sub_array': {
                'data_type': 'ind_codes',
                'ind_code_type': '@TypeText',
                'ind_code': 'IndustryCode.$',
                'ind_code_desc': 'IndustryCodeDescription.0.$',
                'disp_seq': 'DisplaySequence'
            }
        }
    },

    /*
     * @property {Object} searchDD Data Dictionary For D&B Search API Response
     */
    searchDD: {
        'companyname': {
            'json_path': 'OrganizationPrimaryName.OrganizationName.$',
            'case_fmt': true
        },
        'duns_num': {
            'json_path': 'DUNSNumber'
        },
        'locationtype': {
            'json_path': 'locationtype',
            'case_fmt': true
        },
        'streetaddr': {
            'json_path': 'PrimaryAddress.StreetAddressLine.0.LineText',
            'case_fmt': true
        },
        'town': {
            'json_path': 'PrimaryAddress.PrimaryTownName',
            'case_fmt': true
        },
        'territory': {
            'json_path': 'PrimaryAddress.TerritoryOfficialName',
            'case_fmt': true
        },
        'ctrycd': {
            'json_path': 'PrimaryAddress.CountryISOAlpha2Code'
        },
        'isDupe': {
            'json_path': 'isDupe'
        },
        'recordNum': {
            'json_path': 'DisplaySequence'
        }
    },
    accountsDD: null,
    //dnb append service json paths
    appendSVCPaths: {
        'responseCode': 'OrderProductResponse.TransactionResult.ResultID',
        'responseMsg': 'OrderProductResponse.TransactionResult.ResultText',
        'industry': 'OrderProductResponse.OrderProductResponseDetail.Product.Organization.IndustryCode.IndustryCode',
        'product': 'OrderProductResponse.OrderProductResponseDetail.Product.Organization',
        'duns': 'OrderProductResponse.OrderProductResponseDetail.InquiryDetail.DUNSNumber',
        'idc': 'Telecommunication.TelephoneNumber.0.InternationalDialingCode'
    },
    //common json paths
    commonJSONPaths: {
        'industryCode': 'IndustryCode.$',
        'industryType': '@DNBCodeValue',
        'srchRespCode': 'FindCompanyResponse.TransactionResult.ResultID',
        'srchRespMsg': 'FindCompanyResponse.TransactionResult.ResultText',
        'srchRslt': 'FindCompanyResponse.FindCompanyResponseDetail.FindCandidate',
        'competitors': 'FindCompetitorResponse.FindCompetitorResponseDetail.Competitor',
        'industryprofile': 'OrderProductResponse.OrderProductResponseDetail.Product.IndustryProfile',
        'srchCount': 'FindCompanyResponse.FindCompanyResponseDetail.CandidateMatchedQuantity',
        'cmCount': 'GetCleanseMatchResponse.GetCleanseMatchResponseDetail.MatchResponseDetail.CandidateMatchedQuantity'
    },
    //common error codes with error labels
    commonErrorMap: {
        'ERROR_DNB_CONFIG': 'LBL_DNB_NOT_CONFIGURED',
        'ERROR_CURL_5': 'LBL_DNB_ERROR_CURL_RESOLVE_PROXY',
        'ERROR_CURL_6': 'LBL_DNB_ERROR_CURL_RESOLVE_HOST',
        'ERROR_CURL_7': 'LBL_DNB_ERROR_CURL_CONNECTION_FAIL',
        'ERROR_CURL_56': 'LBL_DNB_ERROR_CURL_NETWORK_FAIL',
        'ERROR_DNB_SVC_ERR': 'LBL_DNB_SVC_ERR',
        'ERROR_DNB_UNKNOWN': 'LBL_DNB_UNKNOWN_ERROR',
        'ERROR_EMPTY_PARAM': 'LBL_DNB_EMPTY_PARAM',
        'ERROR_BAD_REQUEST': 'EXCEPTION_MISSING_PARAMTER',
        'ERROR_INVALID_MODULE_NAME': 'LBL_DNB_INVALID_MODULE_NAME'
    },
    //formatting functions map
    formatTypeMap: null,

    contactConst: {
        'responseCode' : 'FindContactResponse.TransactionResult.ResultID',
        'responseMsg' : 'FindContactResponse.TransactionResult.ResultText',
        'contactsPath' : 'FindContactResponse.FindContactResponseDetail.FindCandidate',
        'contactsDetailPath' : 'OrderProductResponse.OrderProductResponseDetail.Product.Organization.PrincipalsAndManagement.CurrentPrincipal.0',
        'premCntct' : 'dnb-cnt-prem',
        'stdCntct' : 'dnb-cnt-std',
        'srchCount': 'FindContactResponse.FindContactResponseDetail.CandidateMatchedQuantity',
        'orgName': 'OrderProductResponse.OrderProductResponseDetail.Product.Organization.OrganizationName.OrganizationPrimaryName.0.OrganizationName.$'
    },

    //dashlets that occupy the full sidepane
    //account create and build a list for now
    sidePaneDashlets: {
        'dnb-account-create': 'LBL_DNB_ACC_CRT',
        'dnb-bal-results': 'LBL_DNB_BAL'
    },

    contactsListDD: {
        'jobTitle' : {
            'json_path' : 'JobTitle.0.JobTitleText.$'
        },
        'fullName' : {
            'json_path' : 'ContactName.FullName'
        },
        'principalId' : {
            'json_path' : 'PrincipalIdentificationNumberDetail.0.PrincipalIdentificationNumber'
        },
        'emailInd' : {
            'json_path' : 'DirectTelephoneInformationAvailableIndicator'
        },
        'phoneInd' : {
            'json_path' : 'DirectEmailInformationAvailableIndicator'
        },
        'isDupe' : {
            'json_path' : 'isDupe'
        },
        'companyName' : {
            'json_path' : 'OrganizationPrimaryName.OrganizationName.$'
        },
        'dunsNum' : {
            'json_path' : 'DUNSNumber'
        },
        'recordNum': {
            'json_path': 'DisplaySequence'
        }
    },

    //contacts detail data dictionary
    contactsDetailDD: {
        'full_name' : {
            'json_path' : 'PrincipalName.FullName',
            'label' : 'LBL_DNB_CONTACT_NAME'
        },
        'account_name': {
            'json_path' : 'orgName',
            'label' : 'LBL_DNB_BAL_ORG_NAME'
        },
        'dnb_principal_id': {
            'json_path': 'PrincipalIdentificationNumberDetail.PrincipalIdentificationNumber'
        },
        'title' : {
            'json_path' : 'JobTitle',
            'label' : 'LBL_DNB_CONTACT_JOBTITLE',
            'sub_object': {
                'data_type' : 'job_hist',
                'title' : 'JobTitleText.$',
                'start_date' : 'StartDate.$',
                'end_date' : 'EndDate.$'
            }
        },
        'department' : {
            'json_path' : 'CurrentManagementResponsibility.0.ManagementResponsibilityText.$',
            'label' : 'LBL_DNB_CONTACT_RESP'
        },
        'email' : {
            'json_path' : 'Telecommunication.EmailAddress.0.TelecommunicationAddress',
            'label' : 'LBL_DNB_CONTACT_EMAIL'
        },
        'phone_work' : {
            'json_path' : 'Telecommunication.TelephoneNumber.0.TelecommunicationNumber',
            'label' : 'LBL_DNB_CONTACT_PHONE'
        },
        'first_name': {
            'json_path': 'PrincipalName.FirstName'
        },
        'last_name': {
            'json_path': 'PrincipalName.LastName'
        },
        'salutation': {
            'json_path': 'PrincipalName.NamePrefix.NamePrefixText'
        },
        'emp_bio' : {
            'json_path' : 'EmploymentBiography.EmploymentBiographyText',
            'label' : 'LBL_DNB_CONTACT_BIO'
        },
        'comp_hist' : {
            'json_path' : 'FormerCompensation',
            'sub_object': {
                'data_type' : 'comp_hist',
                'comp_det' : 'CompensationDetail',
                'comp_date' : 'CompensationDate.$',
                'comp_type' : 'CompensationTypeText.$',
                'comp_amt' : 'CompensationAmount.$',
                'comp_curr' : 'CompensationAmount.@CurrencyISOAlpha3Code'
            }
        }
    },

    contactAttr: ['email', 'phone_work', 'dnb_principal_id', 'first_name', 'last_name', 'full_name', 'department', 'title', 'salutation'],

    //dashlet initialize
    initDashlet: function() {
        this.accountsDD = {
            'name': this.compinfoDD.compname,
            'billing_address_street': this.compinfoDD.primaddrstreet,
            'billing_address_city': this.compinfoDD.primaddrcity,
            'billing_address_state': this.compinfoDD.primaddrstateabbr,
            'billing_address_country': this.compinfoDD.primaddrctrycd,
            'billing_address_postalcode': this.compinfoDD.primaddrzip,
            'website': this.compinfoDD.webpage,
            'phone_office': this.compinfoDD.phone,
            'employees': this.compinfoDD.indempcnt,
            'annual_revenue': {
                'json_path': 'Financial.KeyFinancialFiguresOverview.0',
                'sub_object': {
                    'data_type': 'sales_rev',
                    'units': 'SalesRevenueAmount.0.@UnitOfSize',
                    'currency_cd': 'SalesRevenueAmount.0.@CurrencyISOAlpha3Code',
                    'financial_yr': 'StatementHeaderDetails.FinancialStatementToDate.$',
                    'amount': 'SalesRevenueAmount.0.$',
                    'label': 'LBL_DNB_SALES_REVENUE'
                }
            },
            'ownership': this.compinfoDD.cntrowntype,
            'sic_code': {
                'json_path': 'IndustryCode.IndustryCode',
                'sub_object': {
                    'data_type': 'prim_sic',
                    'sic_type_code' : 3599,
                    'ind_code': 'IndustryCode.$',
                    'label': 'LBL_DNB_SIC'
                }
            }
        };
        this.formatTypeMap = {
            'emp_det': this.formatEmployeeDet,
            'ind_codes': this.formatIndCodes,
            'tpa': this.formatTPA,
            'sales_rev': this.formatAnnualSales,
            'prim_sic': this.formatPrimSic,
            'org_id': this.formatOrgId,
            'phone_idc': this.formatPhone
        };
        this.leadsAttr = this.contactAttr.slice();
        this.leadsAttr.push('account_name');
        this.targetAttr = this.leadsAttr.slice();
        this.personTypeAttrList = {
            'Contacts': this.contactAttr,
            'Leads': this.leadsAttr,
            'Prospects': this.targetAttr
        };
    },

    /**
     * Check if a particular json path is valid
     * @param {Object} obj
     * @param {String} path
     * @return {Boolean}
     */
    checkJsonNode: function(obj, path) {
        var args = path.split('.');
        for (var i = 0; i < args.length; i++) {
            if (_.isNull(obj) || _.isUndefined(obj) || !obj.hasOwnProperty(args[i])) {
                return false;
            }
            obj = obj[args[i]];
        }
        return true;
    },

    /**
     * Checks if
     * 1. User has access to the field using the acl api
     * 2. Checks is the user layout has the field
     * @param {String} fieldName
     */
    checkFieldExists: function(fieldName) {
        var checkUserAccess = app.acl.hasAccess('view', this.module, null, fieldName);
        if (checkUserAccess) {
            var viewMeta = App.metadata.getView(this.module, 'record');
            var fieldExists = _.find(_.flatten(_.pluck(viewMeta.panels, 'fields')), function(fieldObj) {
                return fieldObj.name === fieldName;
            });
        } else {
            return false;
        }
        return fieldExists;
    },

    /**
     * Checks and Process the error
     * @param {Object} xhr
     * @param {Object} status
     * @param {Object} error
     */
    checkAndProcessError: function(xhr, status, error) {
        if (this.disposed) {
            return;
        }
        this.dnbError = {};
        var errorCode = xhr.code,
            errorMessage, errorLink;
        if (!_.isUndefined(errorCode)) {
            app.logger.error('D&B API Error:' + errorCode);
            errorMessage = this.commonErrorMap[errorCode];
            if (_.isUndefined(errorMessage)) {
                errorMessage = app.lang.get('LBL_DNB_API_ERR') + ':' + errorCode;
            }
            if (errorCode === 'ERROR_DNB_CONFIG') {
                errorLink = this.commonConst.connectorSettingsURL;
            } else if (errorCode.indexOf('ERROR_CURL_') !== -1) {
                errorLink = this.commonConst.systemSettingsURL;
            }
        } else {
            errorMessage = this.commonErrorMap['ERROR_DNB_UNKNOWN'];
        }
        this.dnbError.errMsg = errorMessage;
        if (!_.isUndefined(errorLink)) {
            this.dnbError.errorLink = errorLink;
        }
        var dashletLabel = this.sidePaneDashlets[this.name];
        //to handle dashlets that occupy the entire sidePane
        if (!_.isUndefined(dashletLabel)) {
            this.template = app.template.get('dnb.dnb-sidepane-error');
            this.dnbError.label = dashletLabel;
        } else {
            this.template = app.template.get('dnb.dnb-error');
        }

        this.renderErrorMessage();
    },

    /**
     * Renders the actual error message that has been set on the error template
     */
    renderErrorMessage: function() {
        this.render();
        this.$('div#error-display').show();
        this.$('.showLessData').hide();
    },

    /**
     * Check if a particular json path is valid and returns value if valid else return nothing
     * @param {Object} obj
     * @param {String} path
     * @return {Array|Object|null}
     */
    getJsonNode: function(obj, path) {
        var args = path.split('.');
        for (var i = 0; i < args.length; i++) {
            if (_.isNull(obj) || _.isUndefined(obj) || !obj.hasOwnProperty(args[i])) {
                return;
            }
            obj = obj[args[i]];
        }
        return obj;
    },

    /**
     * Gets company information for a DUNS number
     * @param {String} duns_num -- duns_num of the company
     * @param {String} prod_code -- DCP_BAS or DCP_STD or DCP_PREM (referring to the 3 types of comp info dashlets)
     * @param {String} backToListLabel -- label to be rendered to redirect to the previous view
     * @param {Function} renderFunction -- a function to be called to render the dnbapiresponse
     */
    baseCompanyInformation: function(duns_num, prod_code, backToListLabel, renderFunction) {
        var self = this;
        var firmoParams = {
            'duns_num': duns_num,
            'prod_code': prod_code
        };
        var cacheKey = 'dnb:' + firmoParams.duns_num + ':' + firmoParams.prod_code,
            resultData;
        var cacheContent = app.cache.get(cacheKey);
        if (cacheContent) {
            resultData = cacheContent;
            if (backToListLabel) {
                resultData.backToListLabel = backToListLabel;
            }
            renderFunction.call(self, resultData);
        } else {
            var dnbProfileUrl = app.api.buildURL('connector/dnb/firmographic', '', {}, {});
            resultData = {'product': null, 'errmsg': null, 'backToListLabel': null};
            app.api.call('create', dnbProfileUrl, {'qdata': firmoParams}, {
                success: function(data) {
                    var responseCode = self.getJsonNode(data, self.appendSVCPaths.responseCode),
                        responseMsg = self.getJsonNode(data, self.appendSVCPaths.responseMsg);
                    if (!_.isUndefined(responseCode) && responseCode === 'CM000') {
                        resultData.product = data;
                        //if primary sic is available set it
                        //TODO: move to js preprocessing
                        // as a part of the handlebars normalization
                        var industryCodeArray = self.getJsonNode(data, self.appendSVCPaths.industry);
                        if (!_.isUndefined(industryCodeArray)) {
                            //399 is the industry code type value for US SIC
                            resultData.product.primarySIC = self.getPrimaryIndustry(industryCodeArray, self.commonConst.sic_code);
                        }
                        app.cache.set(cacheKey, resultData);
                    } else {
                        resultData.errmsg = responseMsg || app.lang.get('LBL_DNB_SVC_ERR');
                    }
                    if (!_.isUndefined(backToListLabel)) {
                        resultData.backToListLabel = backToListLabel;
                    }
                    renderFunction.call(self, resultData);
                },
                error: _.bind(self.checkAndProcessError, self)
            });
        }
    },

    /**
     * Gets the primary industry code from the array of industry codes
     * @param {Array} industryArray
     * @param {String} industryCode
     * @return {Object}
     */
    getPrimaryIndustry: function(industryArray, industryCode) {
        return _.find(industryArray, function(industryObj) {
            return industryObj['@DNBCodeValue'] === industryCode && industryObj['DisplaySequence'] === 1;
        });
    },

    /**
     * Preprocessing company information / handlebars normalization
     * @param  {Object} firmoResponse -- DNB API Response for Firmographics
     * @param  {Object} dataElementsMap -- Data Elements Map
     * @return {Array}  -- to be passed to the hbs file
     */
    formatCompanyInfo: function(firmoResponse, dataElementsMap) {
        var productDetails = this.getJsonNode(firmoResponse, this.appendSVCPaths.product);
        var formattedDataElements = [];
        if (productDetails) {
            //iterate thru the compinfo map
            _.each(dataElementsMap, function(value, key) {
                //extract the informtaion
                var dnbDataElement = null, dnbDataObj;
                if (key === 'orgid') {
                    //if the key is orgId
                    dnbDataElement = this.getJsonNode(productDetails, value.json_path);
                    var formattedOrgIds = this.formatOrgId(dnbDataElement, value.sub_array);
                    if (!_.isEmpty(formattedOrgIds)) {
                        formattedDataElements = formattedDataElements.concat(formattedOrgIds);
                    }
                } else if (value.sub_array) {
                    //if the data map is array then traverse the nested array
                    dnbDataElement = this.getJsonNode(productDetails, value.json_path);
                    _.each(dnbDataElement, function(dnbSubData) {
                        dnbDataObj = this.formatTypeMap[value.sub_array.data_type].call(this, dnbSubData, value.sub_array);
                        if (!_.isNull(dnbDataObj)) {
                            formattedDataElements.push(dnbDataObj);
                        }
                    }, this);
                } else if (value.sub_object) {
                    dnbDataElement = this.getJsonNode(productDetails, value.json_path);
                    dnbDataObj = this.formatTypeMap[value.sub_object.data_type].call(this, dnbDataElement, value.sub_object);
                    if (!_.isNull(dnbDataObj)) {
                        formattedDataElements.push(dnbDataObj);
                    }
                } else {
                    //else it is a straightforward data element
                    dnbDataElement = this.getJsonNode(productDetails, value.json_path);
                    dnbDataObj = {};
                    //populate a json object
                    if (dnbDataElement) {
                        if (value.case_fmt) {
                            dnbDataElement = this.properCase(dnbDataElement);
                        }
                        dnbDataObj.dataElement = dnbDataElement;
                        dnbDataObj.dataLabel = value.label;
                        dnbDataObj.dataName = key;
                        if (value.type === 'link') {
                            dnbDataObj.dataType = 'link';
                        }
                        //push it into an array
                        formattedDataElements.push(dnbDataObj);
                    }
                }
            }, this);
        }
        return formattedDataElements;
    },

    /**
     * Preprocesses employee details
     * @param {Object} employeeObj D&B Current Principal Object
     * @param {Object} empDD Data Dictionary
     * @return {Object}
     */
    formatEmployeeDet: function(employeeObj, empDD) {
        var dnbDataObj = null;
        var jobTitle = this.getJsonNode(employeeObj, empDD.job_title);
        var empName = this.getJsonNode(employeeObj, empDD.full_name);
        if (empName) {
            dnbDataObj = {};
            dnbDataObj.dataElement = this.properCase(empName);
            if (jobTitle) {
                jobTitle = '<i class="fa fa-user"></i>' + this.properCase(jobTitle);
            } else {
                jobTitle = '<i class="fa fa-user"></i>' + app.lang.get('LBL_DNB_ASSOCIATE');
            }
            dnbDataObj.dnbLabel = jobTitle;
        }
        return dnbDataObj;
    },

    /**
     * Preprocesses third party assesment (tpa)
     * @param {Object} tpaObj D&B Current Principal Object
     * @param {Object} tpaDD from the Data Dictionary
     * @return {Object} with label and dataelement
     */
    formatTPA: function(tpaObj, tpaDD) {
        var dnbDataObj = null;
        var assmt = this.getJsonNode(tpaObj, tpaDD.assmt);
        var assmt_type = this.getJsonNode(tpaObj, tpaDD.assmt_type);
        if (assmt && assmt_type) {
            dnbDataObj = {};
            dnbDataObj.dataElement = this.properCase(assmt);
            dnbDataObj.dnbLabel = this.properCase(assmt_type);
        }
        return dnbDataObj;
    },

    /**
     * Preprocesses industry code to get primary industry code
     * @param {Array} indCdArr industryCode Array
     * @param {Object} indSicDD industryCode data dic
     * @return {Object} with label and dataelement
     */
    formatPrimSic: function(indCdArr, indSicDD) {
        var dnbDataObj = null, primSicCode = null, primSicObj = this.getPrimaryIndustry(indCdArr, indSicDD.sic_type_code);
        if (primSicObj) {
            primSicCode = this.getJsonNode(primSicObj, indSicDD.ind_code);
            if (primSicCode) {
                dnbDataObj = {};
                dnbDataObj.dataElement = primSicCode;
                dnbDataObj.dataLabel = indSicDD.label;
                dnbDataObj.dataName = 'sic_code';
            }
        }
        return dnbDataObj;
    },

    /**
     * Preprocesses employee details
     * @param {Object} indCodeObj D&B Current Principal Object
     * @param {Object} indDD Data Dictionary
     * @return {Object} with label and dataelement
     */
    formatIndCodes: function(indCodeObj, indDD) {
        var dnbDataObj = null;
        var ind_code_type = this.getJsonNode(indCodeObj, indDD.ind_code_type);
        var ind_code_desc = this.getJsonNode(indCodeObj, indDD.ind_code_desc);
        var ind_code = this.getJsonNode(indCodeObj, indDD.ind_code);
        var disp_seq = this.getJsonNode(indCodeObj, indDD.disp_seq);
        var primaryHTML = '<span class="label label-success pull-right" data-placement="right">' + app.lang.get('LBL_DNB_PRIMARY') + '</span>';
        if (ind_code_desc) {
            dnbDataObj = {};
            // ind_code_desc = this.properCase(ind_code_desc);
            if (disp_seq && disp_seq === 1) {
                dnbDataObj.dataElement = ind_code_desc + primaryHTML;
            } else {
                dnbDataObj.dataElement = ind_code_desc;
            }
            dnbDataObj.dnbLabel = ind_code_type + ':' + ind_code;
        }
        return dnbDataObj;
    },

    /**
     * Preprocesses organization identification number
     * @param {Array} orgIdArr
     * @param {Object} orgIdDD Data Dictionary
     * @return {Array}
     */
    formatOrgId: function(orgIdArr, orgIdDD) {
        var uniqueOrgIds = _.uniq(_.pluck(orgIdArr,'OrganizationIdentificationNumber'));
        var uniqueOrgIdObjects = [],
            formattedObjects = [];
        _.each(uniqueOrgIds, function(orgId) {
            uniqueOrgIdObjects.push(_.find(orgIdArr, function(orgIdObj){
                return orgIdObj.OrganizationIdentificationNumber === orgId;
            }));
        });
        _.each(uniqueOrgIdObjects, function(orgIdObj){
            var dnbDataObj = null;
            var org_id_type = this.getJsonNode(orgIdObj, orgIdDD.org_id_type);
            var org_id = this.getJsonNode(orgIdObj, orgIdDD.org_id);
            if (!_.isUndefined(org_id_type) && org_id_type !== 'Unknown'
                && !_.isUndefined(org_id) ) {
                dnbDataObj = {};
                dnbDataObj.dataElement = org_id;
                dnbDataObj.dnbLabel = org_id_type;
                formattedObjects.push(dnbDataObj);
            }
        }, this);
        return formattedObjects;
    },

    /**
     * Preprocessing search results
     * @param {Object} srchResults DNB API Response for search results
     * @param {Object} searchDD Data Elements Map
     * @return {Array} of json objects -- to be passed to the hbs file
     */
    formatSrchRslt: function(srchResults, searchDD) {
        var formattedSrchRslts = [];
        //assigning location type
        _.each(srchResults, function(companyObj) {
            if (companyObj.FamilyTreeMemberRole) {
                //we are relying on DNBCodeValue
                //higher the code value more the precedence in the family tree role
                //hence we are using the _.max function
                var locationType = _.max(companyObj.FamilyTreeMemberRole, function(memberRole) {
                    return memberRole.FamilyTreeMemberRoleText['@DNBCodeValue'];
                });
                //if the location type is parent then we need not display it
                var ftRole = this.getJsonNode(locationType, 'FamilyTreeMemberRoleText.$');
                if (!_.isUndefined(ftRole) && ftRole !== 'Parent') {
                    companyObj.locationtype = ftRole;
                }
            }
        }, this);
        //iterate thru the search results, extract the necessary info
        //populate a js object
        //push it through an array
        _.each(srchResults, function(searchResultObj) {
            var frmtSrchRsltObj = {};
            _.each(searchDD, function(value, key) {
                var dataElement = this.getJsonNode(searchResultObj, value.json_path);
                if (value.sub_object) {
                    var dnbDataObj = this.formatTypeMap[value.sub_object.data_type].call(this, dataElement, value.sub_object);
                    if (!_.isNull(dnbDataObj)) {
                        frmtSrchRsltObj[key] = dnbDataObj;
                    }
                } else {
                    if (dataElement) {
                        if (value.case_fmt) {
                            dataElement = this.properCase(dataElement);
                        }
                        frmtSrchRsltObj[key] = dataElement;
                    }
                }
            }, this);
            formattedSrchRslts.push(frmtSrchRsltObj);
        }, this);
        return formattedSrchRslts;
    },

    /**
     * Preprocesses employee details
     * @param {Object} annsalesObj D&B Current Principal Object
     * @param {Object} annsalesDD Data Dictionary
     * @return {Object} with label and dataelement
     */
    formatAnnualSales: function(annsalesObj, annsalesDD) {
        var dnbDataObj = null;
        var amount = this.getJsonNode(annsalesObj, annsalesDD.amount);
        var units = this.getJsonNode(annsalesObj, annsalesDD.units);
        var currency_cd = this.getJsonNode(annsalesObj, annsalesDD.currency_cd);
        var financial_yr = this.getJsonNode(annsalesObj, annsalesDD.financial_yr);
        if (amount) {
            dnbDataObj = {};
            var finYrHTML = null, unitsStr = null, dnbLabel;
            if (financial_yr) {
                finYrHTML = '<span class="label label-success pull-right" data-placement="right">' + financial_yr + '</span>';
            }
            if (units && currency_cd) {
                unitsStr = '(' + app.lang.get('LBL_DNB_IN') + ' ' + units + ' ' + currency_cd + ')';
            }
            dnbDataObj.dataElement = this.formatSalesRevenue(amount);
            dnbLabel = app.lang.get(annsalesDD.label);
            if (unitsStr) {
                dnbLabel = dnbLabel + unitsStr;
            }
            if (finYrHTML) {
                dnbLabel = dnbLabel + finYrHTML;
            }
            dnbDataObj.dnbLabel = dnbLabel;
            dnbDataObj.dataName = 'annual_revenue';
        }
        return dnbDataObj;
    },

    /**
     * Preprocesses search result
     * @param {Object} phoneObj D&B Current Principal Object
     * @param {Object} phoneDD Data Dictionary
     * @return {Object} with label and dataelement
     */
    formatPhone: function(phoneObj, phoneDD) {
        var dnbDataObj = null;
        var phoneNo = this.getJsonNode(phoneObj, phoneDD.phone_no);
        var idCode = this.getJsonNode(phoneObj, phoneDD.id_code);
        if (phoneNo) {
            dnbDataObj = {};
            dnbDataObj.dataElement = this.appendIDCPhone(phoneNo, idCode);
            dnbDataObj.dataName = phoneDD.data_name;
            dnbDataObj.dnbLabel = app.lang.get(phoneDD.label);
        }
        return dnbDataObj;
    },

    /**
     * Preprocesses search result
     * @param {Number} phoneNo Phone Number
     * @param {Number} idCode International Dailing Code
     * @return {String} phone Number with international dailing code
     */
    appendIDCPhone: function (phoneNo, idCode) {
        var retVal;
        if(idCode) {
            retVal = '+' + idCode + phoneNo.replace(/^0+/, '');
        } else {
            retVal = phoneNo;
        }
        return retVal;
    },

    /**
     * Renders the dnb company details for adding companies from dashlets
     * @param {Object} companyDetails dnb api response for company details
     */
    renderCompanyDetails: function(companyDetails) {
        if (this.disposed) {
            return;
        }
        var formattedFirmographics, dnbFirmo = {};
        //if there are no company details hide the import button
        if (companyDetails.errmsg) {
            if (this.layout.getComponent('dashlet-toolbar').getField('import_dnb_data')) {
                this.layout.getComponent('dashlet-toolbar').getField('import_dnb_data').getFieldElement().hide();
            }
        } else if (companyDetails.product) {
            if (this.layout.getComponent('dashlet-toolbar').getField('import_dnb_data')) {
                this.layout.getComponent('dashlet-toolbar').getField('import_dnb_data').getFieldElement().show();
            }
            if (companyDetails.product) {
                formattedFirmographics = this.formatCompanyInfo(companyDetails.product, this.accountsDD);
                dnbFirmo.product = formattedFirmographics;
                dnbFirmo.backToListLabel = companyDetails.backToListLabel;
            } else if (companyDetails.errmsg) {
                dnbFirmo.errmsg = companyDetails.errmsg;
            }
            this.currentCompany = companyDetails.product;
        }
        this.dnbFirmo = dnbFirmo;
        this.render();
        this.$('div#dnb-company-detail-loading').hide();
        this.$('div#dnb-company-details').show();
    },

    /**
     * Renders the dnb company information for Lite, Standard and Premium dashlets
     * @param {Object} companyDetails dnb api response for company details
     */
    renderCompanyInformation: function(companyDetails) {
        if (this.disposed) {
            return;
        }
        this.template = app.template.get('dnb.dnb-comp-info');
        var formattedFirmographics, dnbFirmo = {};
        if (companyDetails.product) {
            formattedFirmographics = this.formatCompanyInfo(companyDetails.product, this.filteredDD);
            dnbFirmo.product = formattedFirmographics;
        } else if (companyDetails.errmsg) {
            dnbFirmo.errmsg = companyDetails.errmsg;
        }
        this.dnbFirmo = dnbFirmo;
        this.render();
        this.$('div#dnb-compinfo-loading').hide();
        this.$('div#dnb-compinfo-details').show();
        this.$('.showLessData').hide();
    },

    /**
     * Import D&B Accounts Data
     */
    importDNBData: function() {
        var accountsModel = this.getAccountsModel(this.currentCompany);
        if (!_.isUndefined(accountsModel)) {
            var self = this;
            app.drawer.open({
                layout: 'create',
                context: {
                    create: true,
                    module: 'Accounts',
                    model: accountsModel
                }
            }, function(accountsModel) {
                if (!accountsModel) {
                    return;
                }
                self.context.resetLoadFlag();
                self.context.set('skipFetch', false);
                self.context.loadData();
            });
        }
    },

    /**
     * Creates and returns an Account bean
     * @param  {Object} companyApiResponse -- obj -- dnb api response for company information
     * @return {Object}
     */
    getAccountsModel: function(companyApiResponse) {
        var organizationDetails = this.getJsonNode(companyApiResponse, this.appendSVCPaths.product);
        var accountsModel = null;
        var idcode = this.getJsonNode(organizationDetails, this.appendSVCPaths.idc);
        if (!_.isUndefined(organizationDetails)) {
            var accountsBean = {};
            if (companyApiResponse.primarySIC) {
                organizationDetails.primarySIC = companyApiResponse.primarySIC;
            }
            _.each(this.accountsMap, function(dataElementPath, sugarColumnName) {
                var dnbDataElement = this.getJsonNode(organizationDetails, dataElementPath);
                if (dnbDataElement) {
                    if (sugarColumnName === 'annual_revenue') {
                        dnbDataElement = this.formatSalesRevenue(dnbDataElement);
                    } else if (sugarColumnName === 'phone_office') {
                        dnbDataElement = this.appendIDCPhone(dnbDataElement, idcode)
                    }
                    accountsBean[sugarColumnName] = dnbDataElement;
                }
            }, this);
            accountsModel = app.data.createBean('Accounts', accountsBean);
        }
        return accountsModel;
    },

    /**
     * Collapses the dashlet
     */
    collapseDashlet: function() {
        if (this.layout.collapse) {
            this.layout.collapse(true);
        }
    },

    /**
     * Expands the dashlets to reveal more data
     */
    showMoreData: function() {
        this.$('.dnb-show-less').attr('class', 'dnb-show-all');
        this.$('.showLessData').show();
        this.$('.showMoreData').hide();
    },

    /**
     * Truncates the dashlets
     */
    showLessData: function() {
        this.$('.dnb-show-all').attr('class', 'dnb-show-less');
        this.$('.showLessData').hide();
        this.$('.showMoreData').show();
    },

    /**
     * Formats the sales revenue amount
     * @param  {String} amount sales revenue
     * @return {String} formatted string
     */
    formatSalesRevenue: function(amount) {
        if (_.isNumber(amount)) {
            amount = amount.toFixed(0).replace(/(\d)(?=(\d{3})+\b)/g, '$1,');
        }
        return amount;
    },

    /**
     * Formats the string to proper case
     * @param {String}  strParam string to convert
     * @return {String}  properCase String
     */
    properCase: function(strParam) {
        // The following is provided for your convenience should you wish to learn more about
        // Convert string to title case with javascript.
        // For a list of the actual third party software used in this Sugar product,
        // please visit http://support.sugarcrm.com/06_Customer_Center/11_Third_Party_Software/.
        //
        // http://stackoverflow.com/a/196991/226906
        return strParam.replace(/\w\S*/g, function(txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    },

    /**
     * Imports data from dashlet to the sugar crm accounts
     * @param {Boolean} importFlag (When set to true indicates warning message must not be displayed for the first data import
     *                 This requirement was suggested by Wes in the Account creation screen
     *                 Where a user searches for a company name using a keyword
     *                 So when the user imports data for the first time
     *                 It is pretty obvious that he wants to override the keyword with the newly imported data
     *                 setting the flag to false prevents the warning message from being displayed
     *                )
     */
    importAccountsData: function(importFlag) {
        var setModelFlag = true;
        if (_.isUndefined(importFlag)) {
            importFlag = true;
            setModelFlag = false;
        } else if (importFlag) {
            setModelFlag = false;
        }
        var dnbCheckBox = this.$('.dnb_checkbox:checked');
        var accountsModel = this.model;
        // iterate through checkboxes
        // values being overriden stored in updatedData
        // values that are newly being set store in newData
        var updatedData = [], newData = [], dnbPropertyName = null, dnbPropertyValue = null, dnbPropertySelector = null;
        _.each(dnbCheckBox, function(dataElement) {
            dnbPropertyName = dataElement.id;
            if (dnbPropertyName) {
                //we are cloning the selected property value
                //so that we can remove the nested html elements and retain the text alone
                dnbPropertySelector = this.$('#' + dnbPropertyName). parent().siblings('.importData').clone();
                dnbPropertyValue = $.trim(dnbPropertySelector.children().remove().end().text());
                if (!_.isUndefined(accountsModel.get(dnbPropertyName)) && accountsModel.get(dnbPropertyName) !== '' && importFlag) {
                    updatedData.push({propName: dnbPropertyName, propVal: dnbPropertyValue});
                } else if (dnbPropertyValue !== '') {
                    newData.push({propName: dnbPropertyName, propVal: dnbPropertyValue});
                }
            }
        }, this);

        // Import new data, but only if updated data is empty, otherwise the
        // next conditional block will handle it
        if (newData.length > 0) {
            this.updateAccountsModel(newData, setModelFlag);
        }

        // Update the model based on changes, making sure to not save the model
        if (updatedData.length > 0) {
            var confirmationMsgKey;
            var confirmationMsgData;

            // Import flag is true when we've already set the model based on an
            // import selection. If it comes in again as false, the model will
            // save when updated, which will save a new record in the database
            // without a save event being fired. This fixes that.
            var setModelOnlyFlag = importFlag === true;

            //show a detailed warning message about the single data element being imported
            if (updatedData.length === 1) {
                var fieldName = app.lang.get(accountsModel.fields[updatedData[0].propName].vname, 'Accounts');
                confirmationMsgKey = 'LBL_DNB_DATA_OVERRIDE_SINGLE_FIELD';
                confirmationMsgData = {
                    fieldName: fieldName.toLowerCase(),
                    value: updatedData[0].propVal
                };
            } else {
                var fieldList = [
                    app.lang.get(accountsModel.fields[updatedData[0].propName].vname, 'Accounts').toLowerCase(), app.lang.get(accountsModel.fields[updatedData[1].propName].vname, 'Accounts').toLowerCase()
                ];
                if (updatedData.length === 2) {
                    //list the two fields being imported
                    confirmationMsgKey = 'LBL_DNB_DATA_OVERRIDE_TWO_FIELDS';
                    confirmationMsgData = {
                        fields: fieldList.join(' ' + app.lang.get('LBL_DNB_AND') + ' ')
                    };
                } else {
                    //list the two first fields and append ` and other(s) field(s)`
                    confirmationMsgKey = 'LBL_DNB_DATA_OVERRIDE_MULTIPLE_FIELDS';
                    confirmationMsgData = {
                        fields: fieldList.join(', ')
                    };
                }
            }
            var confirmationMsgTpl = Handlebars.compile(app.lang.get(confirmationMsgKey));
            app.alert.show('dnb-import-warning', {
                level: 'confirmation',
                title: 'LBL_WARNING',
                messages: confirmationMsgTpl(confirmationMsgData),
                onConfirm: _.bind(this.updateAccountsModel, this, updatedData, setModelOnlyFlag)
            });
        }
    },

    /**
     * Updates the Accounts backbone model with new data
     * @param {Object} updatedData
     * @param {Boolean} setFlag -- true -- just set the updated parameters to the model
     *                    -- false -- save the updated parameters to the model
     */
    updateAccountsModel: function(updatedData, setFlag) {
        var changedAttributes = {};
        // always import the duns_num
        this.model.set('duns_num', this.duns_num);
        if (setFlag) {
            _.each(updatedData, function(updatedAttribute) {
                this.model.set(updatedAttribute.propName, updatedAttribute.propVal);
            }, this);
            app.alert.show('dnb-import-success', { level: 'success',
                title: app.lang.get('LBL_SUCCESS') + ':',
                messages: app.lang.get('LBL_DNB_OVERRIDE_SUCCESS'),
                autoClose: true});
        } else {
            _.each(updatedData, function(updatedAttribute) {
                changedAttributes[updatedAttribute.propName] = updatedAttribute.propVal;
            });
            this.model.save(changedAttributes, {success: function() {
                app.alert.show('dnb-import-success', { level: 'success',
                    title: app.lang.get('LBL_SUCCESS') + ':',
                    messages: app.lang.get('LBL_DNB_OVERRIDE_SUCCESS'),
                    autoClose: true});
            }});
            this.context.loadData();
        }
    },

    /**
     * Filters the data elements for the company information
     */
    baseFilterData: function() {
        this.filteredDD = {};
        _.each(this.compinfoDD, function(value, key) {
            var settingsFlag = this.settings.get(key);
            //if the settings flag is defined and is selected then
            //add that property to the filtered data dictionary
            if (!_.isUndefined(settingsFlag) && settingsFlag === true) {
                this.filteredDD[key] = value;
            } else if (_.isUndefined(settingsFlag)) {
                //if the settings flag is not defined
                //select it by default
                this.filteredDD[key] = value;
                this.settings.set(key, true);
            }
        }, this);
    },

    /**
     * Checks the Sugar data base for duplicate duns or contacts
     * @param {Object} dupeCheckParams
     * @param {Function} callBack
     * dupeCheckParams must have the following keys
     * 1.type Possible values are duns,contacts
     * 2.apiResponse
     * 3.module Possible values are findcompany, competitors, cleansematch, familytree, contacts, dunsPage, contactsPage
     */
    baseDuplicateCheck: function(dupeCheckParams, callBack) {
        var dupeCheckURL = app.api.buildURL('connector/dnb/dupecheck', '', {}, {});
        var self = this;
        app.api.call('create', dupeCheckURL, {'qdata': dupeCheckParams}, {
            success: function(data) {
                callBack.call(self, {'product': data});
            },
            error: _.bind(self.checkAndProcessError, self)
        });
    },

    /**
     * Build a list of accounts
     * @param {Object} balParams
     * @param {Function} callBack (function used to render api response)
     */
    baseAccountsBAL: function(balParams, callBack) {
        var balRslt = {'product': null, 'errmsg': null};
        var dnbBalURL = app.api.buildURL('connector/dnb/Accounts/bal', '', {}, {});
        var self = this;
        app.api.call('create', dnbBalURL, {'qdata': balParams}, {
            success: function(data) {
                var responseCode = self.getJsonNode(data, self.commonJSONPaths.srchRespCode),
                    responseMsg = self.getJsonNode(data, self.commonJSONPaths.srchRespMsg);
                if (responseCode && responseCode === self.responseCodes.success) {
                    balRslt.product = data;
                } else {
                    balRslt.errmsg = responseMsg || app.lang.get('LBL_DNB_SVC_ERR');
                }
                callBack.call(self, balRslt);
            },
            error: _.bind(self.checkAndProcessError, self)
        });
    },

    /**
     * Toggles the visibility of the import button in the dashlet
     * @param {String} btnName
     * @param {Boolean} isVisible
     */
    toggleImportBtn: function(btnName, isVisible) {
        if (this.layout.getComponent('dashlet-toolbar').getField(btnName)) {
            if (isVisible) {
                this.layout.getComponent('dashlet-toolbar').getField(btnName).getFieldElement().show();
                this.layout.getComponent('dashlet-toolbar').getField(btnName).getFieldElement().removeClass('hide');
            } else {
                this.layout.getComponent('dashlet-toolbar').getField(btnName).getFieldElement().hide();
            }
        }
    },

    /**
     * Toggles enabled / disabled state of the button on the dashlet toolbar
     * @param {Boolean} isEnabled
     * @param {String} btnName
     */
    toggleDashletBtn: function(isEnabled, btnName) {
        if (this.layout.getComponent('dashlet-toolbar').getField(btnName)) {
            if (isEnabled) {
                this.layout.getComponent('dashlet-toolbar').getField(btnName).setDisabled(false);
                this.layout.getComponent('dashlet-toolbar').getField(btnName).getFieldElement().removeClass('disabled');
                this.layout.getComponent('dashlet-toolbar').getField(btnName).getFieldElement().removeClass('hide');
            } else {
                this.layout.getComponent('dashlet-toolbar').getField(btnName).setDisabled(true);
                this.layout.getComponent('dashlet-toolbar').getField(btnName).getFieldElement().addClass('disabled');
            }
        }
    },

    /**
     * Build a list of contacts
     * @param {Object} balParams
     * @param {Function} renderFunction
     */
    baseContactsBAL: function(balParams, renderFunction) {
        var self = this,
            balRslt = {'product': null, 'errmsg': null},
            dnbBalURL = app.api.buildURL('connector/dnb/Contacts/bal', '', {}, {});
        app.api.call('create', dnbBalURL, {'qdata': balParams}, {
            success: function(data) {
                var responseCode = self.getJsonNode(data, self.contactConst.responseCode),
                    responseMsg = self.getJsonNode(data, self.contactConst.responseMsg);
                if (responseCode && responseCode === self.responseCodes.success) {
                    balRslt.product = data;
                } else {
                    balRslt.errmsg = responseMsg || app.lang.get('LBL_DNB_SVC_ERR');
                }
                renderFunction.call(self, balRslt);
            },
            error: _.bind(self.checkAndProcessError, self)
        });
    },

    /**
     * Preprocessing contacts list
     * @param {Array} dnbApiResponse DNB API Response for Contacts
     * @param {Object} contactsListDD Contacts data dictionary
     * @return {Array} frmtCntctList formatted contacts
     */
    formatContactList: function(dnbApiResponse, contactsListDD) {
        var frmtCntctList = [];
        _.each(dnbApiResponse, function(contactObj) {
            //initialize empty formatted obj
            var frmCntctObj = {};
            //iterate through data dictionary and extract info
            _.each(contactsListDD, function(value, key) {
                var dataElement = this.getJsonNode(contactObj, value.json_path);
                if (dataElement) {
                    frmCntctObj[key] = dataElement;
                }
            },this);
            //only if the contact has a name and a principal id will we display it
            if (frmCntctObj.principalId && frmCntctObj.fullName) {
                if (frmCntctObj.emailInd || frmCntctObj.phoneInd) {
                    frmCntctObj.contactType = this.contactConst.premCntct;
                } else {
                    frmCntctObj.contactType = this.contactConst.stdCntct;
                }
                frmtCntctList.push(frmCntctObj);
            }
        },this);
        return frmtCntctList;
    },

    /**
     * Gets contact details for a duns and principal identification number combination
     * @param {Object} evt
     */
    baseGetContactDetails: function(evt) {
        if (this.disposed) {
            return;
        }
        var contact_id = evt.target.id;
        var duns_num = this.$(evt.target).data('duns');
        var contact_name = evt.target.text, contact_type;
        if (this.$(evt.target).hasClass(this.contactConst.premCntct)) {
            contact_type = this.contactConst.premCntct;
        } else if (this.$(evt.target).hasClass(this.contactConst.stdCntct)) {
            contact_type = this.contactConst.stdCntct;
        }
        if (this.name === 'dnb-bal-results') {
            this.template = app.template.get(this.name + '.dnb-bal-contact-details');
        } else if (this.name === 'dnb-contact-info') {
            this.template = app.template.get(this.name + '.dnb-contact-details');
        }
        this.cntctLoadMsg = {'contactName' : contact_name};
        this.render();
        this.$('div#dnb-contact-details-loading').show();
        this.$('div#dnb-contact-details').hide();
        //hiding the import buttons
        if (this.name === 'dnb-bal-results') {
            this.$('.importContacts').hide();
        } else if (this.name === 'dnb-contact-info') {
            this.toggleImportBtn('import_dnb_data', false);
        }
        var contactParams = {
            'duns_num' : duns_num,
            'contact_id' : contact_id,
            'contact_type' : contact_type
        };
        //check if cache has this data already
        var cacheKey = 'dnb:' + contactParams.contact_type + ':'
            + contactParams.duns_num + ':' + contactParams.contact_id;
        var cacheContent = app.cache.get(cacheKey);
        if (cacheContent) {
            this.currentContact = cacheContent.contactDetail;
            this.renderContactDetails(cacheContent);
        } else {
            var dnbContactDetailsURL = app.api.buildURL('connector/dnb/contacts', '', {},{}),
                resultData = {'contactDetail': null, 'errmsg' : null},
                self = this;
            //maintaining dashlet state
            this.currentContact = null;
            if (!_.isUndefined(this.dashletState)) {
                this.dashletState.view = 'detail';
                this.dashletState.content = cacheKey;
                this.dashletState.params = null;
            }
            app.api.call('create', dnbContactDetailsURL, {'qdata': contactParams},{
                success: function(data) {
                    var responseCode = self.getJsonNode(data, self.appendSVCPaths.responseCode),
                        responseMsg = self.getJsonNode(data, self.appendSVCPaths.responseMsg);
                    if (responseCode && responseCode === self.responseCodes.success) {
                        var contactDetail = self.getJsonNode(data, self.contactConst.contactsDetailPath);
                        if (contactDetail) {
                            var orgName = self.getJsonNode(data, self.contactConst.orgName);
                            if (orgName) {
                                contactDetail.orgName = orgName;
                            }
                            resultData.contactDetail = contactDetail;
                            self.currentContact = resultData.contactDetail;
                            app.cache.set(cacheKey, resultData);
                        } else {
                            resultData.errmsg = app.lang.get('LBL_DNB_NO_DATA');
                        }
                    } else {
                        resultData.errmsg = responseMsg || app.lang.get('LBL_DNB_SVC_ERR');
                    }
                    self.renderContactDetails(resultData);
                },
                error: _.bind(this.checkAndProcessError, self)
            });
        }
    },

    /**
     * Renders the contact details
     * @param {Object} dnbApiResponse dnb api response for contactDetails
     */
    renderContactDetails: function(dnbApiResponse) {
        if (this.disposed) {
            return;
        }
        if (this.name === 'dnb-bal-results') {
            this.template = app.template.get(this.name + '.dnb-bal-contact-details');
        } else if (this.name === 'dnb-contact-info') {
            this.template = app.template.get(this.name + '.dnb-contact-details');
        }
        var frmtCntctDet, dnbCntctDet = {};
        if (dnbApiResponse.contactDetail) {
            frmtCntctDet = this.formatContactDetails(dnbApiResponse.contactDetail, this.contactsDetailDD);
            if (frmtCntctDet) {
                dnbCntctDet.product = frmtCntctDet;
                //passing the list of import_enabled_modules for bal contact details
                if (!_.isUndefined(this.import_enabled_modules)) {
                    dnbCntctDet.product.import_enabled_modules = this.import_enabled_modules;
                }
            } else {
                dnbCntctDet.errmsg = app.lang.get('LBL_DNB_NO_DATA');
            }
        } else if (dnbApiResponse.errmsg) {
            dnbCntctDet.errmsg = dnbApiResponse.errmsg;
        }
        this.dnbCntctDet = dnbCntctDet;
        this.render();
        //if there are no contact details hide the import button
        if (dnbCntctDet.errmsg) {
            if (this.name === 'dnb-bal-results') {
                this.$('.importContacts').hide();
            }
        } else if (dnbCntctDet.product) {
            if (this.name === 'dnb-bal-results') {
                this.$('.importContacts').show();
            } else if (this.name === 'dnb-contact-info') {
                if (this.layout.getComponent('dashlet-toolbar').getField('import_dnb_data')) {
                    this.layout.getComponent('dashlet-toolbar').getField('import_dnb_data').getFieldElement().removeClass('hide');
                    this.layout.getComponent('dashlet-toolbar').getField('import_dnb_data').getFieldElement().show();
                }
            }
            this.currentContact = dnbCntctDet.product;
        }
        this.$('div#dnb-contact-details-loading').hide();
        this.$('div#dnb-contact-details').show();
    },

    /**
     * Preprocessing contact details
     * @param  {Object} contactDetail DNB API Response for contact details
     * @param  {Object} contactsDetailDD Contact Details Data Dictionary
     * @return {Object} frmtCntctDet Format Contact Details Array
     */
    formatContactDetails: function(contactDetail, contactsDetailDD) {
        var frmtCntctDet = {};
        frmtCntctDet.contact_profile = [];
        _.each(contactsDetailDD, function(value, key) {
            var dataElement = this.getJsonNode(contactDetail, value.json_path);
            if (dataElement) {
                if (key === 'title') {
                    var frmtJobTitles = this.formatJobTitles(dataElement, value.sub_object);
                    if (frmtJobTitles && frmtJobTitles.length > 0) {
                        //first job title is the current job title
                        frmtCntctDet[key] = frmtJobTitles[0].title;
                        frmtCntctDet.contact_profile.push({
                            'dataLabel': value.label,
                            'dataElement': frmtJobTitles[0].title
                        });
                        //the rest are used to display job history
                        if (frmtJobTitles.length > 1) {
                            frmtJobTitles.splice(0, 1);
                            frmtCntctDet[value.sub_object.data_type] = frmtJobTitles;
                        }
                    }
                } else if (key === 'comp_hist') {
                    var frmtCompHist = this.formatCompHist(dataElement, value.sub_object);
                    if (frmtCompHist && frmtCompHist.length > 0) {
                        frmtCntctDet[value.sub_object.data_type] = frmtCompHist;
                    }
                } else {
                    //this takes care of formatting general employee information
                    var maskedDataElement, dataObj = {};
                    if (key === 'email') {
                        maskedDataElement = this.emailMask(dataElement);
                    } else if (key === 'phone_work') {
                        maskedDataElement = this.phoneMask(dataElement);
                    }
                    dataObj.dataLabel = value.label;
                    if (!_.isUndefined(maskedDataElement)) {
                        dataObj.dataElement = maskedDataElement;
                    } else {
                        dataObj.dataElement = dataElement;
                    }
                    //this array is for making the hbs readable
                    frmtCntctDet.contact_profile.push(dataObj);
                    //this property is for importing the contact
                    frmtCntctDet[key] = dataElement;
                }
            }
        },this);
        return frmtCntctDet;
    },

    /**
     * Preprocessing job titles
     * @param {Array} jobTitles job titles
     * @param {Object} jobTitleDD job titles data dictionary
     * @return {Array} formatted job titles
     */
    formatJobTitles: function(jobTitles, jobTitleDD) {
        var jobTitleArray = [];
        _.each(jobTitles, function(jobObj) {
            var jobTitleObj = {
                title: this.getJsonNode(jobObj, jobTitleDD.title),
                start_date: this.getJsonNode(jobObj, jobTitleDD.start_date),
                end_date: this.getJsonNode(jobObj, jobTitleDD.end_date)
            };
            if (jobTitleObj.title) {
                jobTitleArray.push(jobTitleObj);
            }
        },this);
        return jobTitleArray;
    },

    /**
     * Preprocessing compensation history
     * @param {Array} compHist compensation history
     * @param {Object} compHistDD compensation history data dictionary
     * @return {Array} frmtCompHist formatted compensation history
     */
    formatCompHist: function(compHist, compHistDD) {
        var frmtCompHist = [];
        _.each(compHist, function(compHistObj) {
            var compDate = this.getJsonNode(compHistObj, compHistDD.comp_date),
                compDet = this.getJsonNode(compHistObj, compHistDD.comp_det),
                frmtCompHistObj = {};
            var frmtCompDet = [];
            _.each(compDet, function(compDetObj) {
                var frmtCompDetObj = {
                    'comp_type' : this.getJsonNode(compDetObj, compHistDD.comp_type),
                    'comp_amt' : this.getJsonNode(compDetObj, compHistDD.comp_amt),
                    'comp_curr' : this.getJsonNode(compDetObj, compHistDD.comp_curr)
                };
                if (frmtCompDetObj.comp_amt) {
                    frmtCompDetObj.comp_amt = this.formatSalesRevenue(frmtCompDetObj.comp_amt);
                    frmtCompDet.push(frmtCompDetObj);
                }
            },this);
            if (frmtCompDet.length > 0 && compDate) {
                frmtCompHistObj.comp_date = compDate;
                frmtCompHistObj.comp_det = frmtCompDet;
                frmtCompHist.push(frmtCompHistObj);
            }
        },this);
        return frmtCompHist;
    },

    /**
     * Masks the email address
     * @param  {String} email
     * @return {String} masked email
     */
    emailMask: function(email) {
        var match = email.match(/([A-Za-z]{2})(.*)(@)(.*)/);
        return match[1] + match[2].replace(/./g, 'x') + match[3] + match[4];
    },

    /**
     * Masks the email address
     * @param  {String} phone
     * @return {String} masked phone
     */
    phoneMask: function(phone) {
        var match = phone.match(/([0-9]{2})(.*)([0-9]{2})/);
        return match[1] + match[2].replace(/./g, 'x') + match[3];
    },

    /**
     * Imports the current contact information
     * @param {String} moduleName Possible values for module are Contact / LinkedContacts / Leads / Prospects
     * LinkedContacts is used to import a contact that is imported from a contacts dashlet that is linked
     * to a sugar account
     */
    baseImportContact: function(moduleName) {
        var model = this.getModuleModel(this.currentContact, moduleName);
        var self = this;
        app.drawer.open({
            layout: 'create',
            context: {
                create: true,
                module: model.module,
                model: model
            }
        }, function(model) {
            if (!model) {
                return;
            }
            self.context.resetLoadFlag();
            self.context.set('skipFetch', false);
            self.context.loadData();
            _.each(app.controller.context.children, function(childContext) {
                if (childContext.get('module') === 'Contacts') {
                    childContext.reloadData({recursive: false});
                }
            });
        });
    },

    /**
     * Creates and returns a Module bean
     * @param {Object} modelBean
     * @param {String} moduleName possible values could be Contacts/LinkedContacts/Leads/Prospects
     * @return {Object} moduleModel
     */
    getModuleModel: function(modelBean, moduleName) {
        var module, moduleModel;
        if (moduleName === 'LinkedContacts') {
            module = 'Contacts';
        } else {
            module = moduleName;
        }
        var filteredModelBean = _.pick(modelBean, this.personTypeAttrList[module]);
        if (filteredModelBean.email) {
            var emailObj = {
                email_address: filteredModelBean.email,
                opt_out: false,
                primary_address: true,
                reply_to_address: false
            };
            filteredModelBean.email = [emailObj];
        }
        //adding properties specific to leads alone
        if (module === 'Leads') {
            filteredModelBean.lead_source = app.lang.get('LBL_DNB_OTHER');
            filteredModelBean.lead_source_description = app.lang.get('LBL_DNB_BAL');
        }
        //handling the scenario where we need to add a contact associated with an account
        if (moduleName === 'LinkedContacts') {
            filteredModelBean.account_id = this.model.get('id');
            filteredModelBean.account_name = this.model.get('name');
            moduleModel = app.data.createRelatedBean(this.model, null, 'contacts', filteredModelBean);
        } else {
            moduleModel = app.data.createBean(module, filteredModelBean);
        }
        return moduleModel;
    },

    /**
     * Gets the next set of records from the recordSet
     * @param {Array} recordSet
     * @param {Number} pageStart
     * @param {Number} pageEnd
     * @return {Array} recordSet
     */
    getNextPage: function(recordSet, pageStart, pageEnd) {
        return _.filter(recordSet, function(resultObj) {
            return resultObj.recordNum >= pageStart && resultObj.recordNum <= pageEnd;
        });
    },

    /**
     * TODO: refactor this to remove the logic
     * Render pagination control
     * @param {String} componentName (Optional)
     */
    renderPaginationControl: function() {
        //it more records exist in api display pagination controls
        if (this.recordCount > this.endRecord) {
            //display pagination controls
            this.$('#dnb-page-ctrl').toggleClass('hide', false);
            this.$('[data-action="show-more"]').removeClass('hide');
            this.$('.loading').hide();
        } else {
            //hide pagination controls
            this.$('#dnb-page-ctrl').toggleClass('hide', true);
        }
    },

    /**
     * Display pagination loading message
     */
    displayPaginationLoading: function() {
        this.$('[data-action="show-more"]').addClass('hide');
        this.$('.loading').show();
    },

    /**
     * Sets pagination offset and page numbers
     */
    setPaginationParams: function() {
        this.pageNo = this.pageNo + 1;
        this.endRecord = this.pageNo * this.pageSize;
        this.startRecord = (this.endRecord - this.pageSize) + 1;
    },

    /**
     * Gets the next set of records from the context
     * Else invoke the
     */
    paginateRecords: function() {
        return this.getNextPage(this.formattedRecordSet, this.startRecord, this.endRecord);
    },

    /**
     * Initialize pagination parameters
     * @param {Number} pageSize
     */
    initPaginationParams: function(pageSize) {
        //# of records to be displayed in the dashlet
        this.pageSize = !_.isUndefined(pageSize) ? pageSize : 10;
        //initial page no.
        this.pageNo = 1;
        //max # of records D&B API to return
        //default to 10 times page size
        this.apiPageSize = 2 * this.pageSize;
        this.apiPageOffset = 1;
        this.startRecord = 1;
        this.endRecord = this.pageSize;
        //sets the record no for the last record from the api
        //this will be used to determine if we can fetch the next set of records
        // from the context or do we need to invoke the api
        this.apiPageEndRecord = (this.apiPageOffset + this.apiPageSize) - 1;
        //setting the current set of formatted records to the context
        //this is to be used for:
        //1. concatenating the next page
        //2. dupe check for back to list
        this.currentPage = null;
        //this flag is used to determine whether pagination params must be reset
        //this would be set to false when we invoke the API pagination
        //this would help us preserve the pagination params across API calls
        this.resetPaginationFlag = true;
    },

    /**
     * Sets pagination params to existing params
     * @param {Object} apiParams
     * @return {Object}
     */
    setApiPaginationParams: function(apiParams) {
        apiParams.CandidatePerPageMaximumQuantity = this.apiPageSize;
        apiParams.CandidateDisplayStartSequenceNumber = this.apiPageOffset;
        return apiParams;
    },

    /**
     * Loads the D&B Dashlets with appropriate data
     * @param {String} modelAttribute
     * @param {String} contextAttribute
     * @param {Function} callBackFunction
     * @param {String} callBackParams
     * @param {String} errorTemplate
     */
    loadDNBData: function(modelAttribute, contextAttribute, callBackFunction, callBackParams, errorTemplate, fieldAclTemplate) {
        if (this.checkFieldExists(modelAttribute)) {
            var field,
            modelAttr = this[modelAttribute],
            contextAttr;
            //get the attribute set in the context
            if (!_.isNull(contextAttribute)) {
                contextAttr = app.controller.context.get(contextAttribute);
            }
            if (!_.isUndefined(modelAttr) && !_.isNull(modelAttr)) {
                field = modelAttr;
            } else if (!_.isUndefined(contextAttr)) {
                field = contextAttr;
            }
            if (!_.isUndefined(field) && !_.isNull(field)) {
                if(!_.isNull(callBackParams)) {
                    callBackFunction.call(this, field, callBackParams);
                } else {
                    callBackFunction.call(this, field);
                }
            } else {
                this.template = app.template.get(errorTemplate);
                if (!this.disposed) {
                    this.render();
                }
            }
        } else {
            this.template = app.template.get(fieldAclTemplate);
            if (!this.disposed) {
                this.render();
            }
        }
    },

    /**
     * Event handler for pagination controls
     * Renders next page from context if available
     * else invokes the D&B API to get the next page
     * @param {Function} paginationCallBack
     * @param {Object} apiParams Parameters for api call
     * @param {Function} callBack
     */
    invokePagination: function(paginationCallBack, apiParams, callBack) {
        this.displayPaginationLoading();
        this.setPaginationParams();
        //if the endRecord after pagination is greater than apiPageEndRecord
        //we have to invoke the api with the pagination controls
        if (this.endRecord > this.apiPageEndRecord && !_.isNull(paginationCallBack)) {
            this.apiPageEndRecord = (this.startRecord + this.apiPageSize) - 1;
            this.resetPaginationFlag = false;
            //setting the apiPageOffset
            this.apiPageOffset = this.startRecord;
            paginationCallBack.call(this, this.setApiPaginationParams(apiParams), callBack);
        } else {
            var pageData = {
                'product':  this.paginateRecords(),
                'count': this.recordCount
            };
            this.renderPage(pageData, true);
        }
    },

    /**
     * Renders the currentPage
     * @param {Object} pageData
     * @param {Boolean} append boolean to indicate if records need to be appended to exsiting list
     */
    renderPage: function(pageData, append) {
        if (_.isUndefined(append) || !append) {
            if (this.disposed) {
                return;
            }
            this.template = this.resultTemplate;
            this.listData = pageData;
            //pageData count is not defined when the page is being rendered after
            //dupe check
            //hence using the count from the context variable
            if (_.isUndefined(pageData.count)) {
                pageData.count = this.recordCount;
            }
            //if the api returns a success response then only set the count
            if (pageData.product && !_.isUndefined(this.resultCountTmpl)) {
                this.listData.count = this.resultCountTmpl + " (" + this.formatSalesRevenue(pageData.count) + ")";
            } else {
                delete this.listData['count'];
            }
            this.render();
        } else {
            this.currentPage = this.currentPage.concat(pageData.product);
            _.each(pageData.product, function(listObj) {
                //compile account row
                var rowHtml = this.rowTmpl(listObj);
                //append account row to exising list
                this.$(this.selectors.rsltList).append(rowHtml);
            }, this);
        }
        this.$(this.selectors.load).toggleClass('hide', true);
        this.$(this.selectors.rslt).toggleClass('hide', false);
        //render pagination controls only if the api returns a success response
        if (pageData.product) {
            this.renderPaginationControl();
        }
    },

    /**
     * Bulk Import D&B Objects
     * @param {Array} bulkArray
     * @param {String} module
     * @param {Function} callBack
     */
    invokeBulkImport: function(bulkArray, module, callBack) {
        //display loading message
        app.alert.show('bulkImport', {
            level: 'process',
            title: app.lang.getAppString('LBL_DNB_BI_LOADING'),
            autoClose: false
        });
        //hide previous
        var bulkImportURL = app.api.buildURL('connector/dnb/' + module + '/bulkimport', '', {},{}),
            self = this;
        app.api.call('create', bulkImportURL, {'bulkdata': bulkArray}, {
            success: function(data) {
                //dismiss loading symbol
                app.alert.dismiss('bulkImport');
                var newAccounts = data.importSuccess,
                    duplicates = data.duplicates,
                    title, level, message;
                var viewAccountsMsg = "<a href='#{{buildRoute module=module}}' data-route='#{{buildRoute module=module}}'>{{str 'LBL_DNB_VIEW_ACCT'}}</a>";
                var viewAcctsHTML = Handlebars.compile(viewAccountsMsg)({'module': self.module});

                if (newAccounts > 0 && duplicates === 0) {
                    level = 'success';
                    title = app.lang.get('LBL_SUCCESS');
                    message = app.lang.get('LBL_DNB_BI_YOU_ADD') + newAccounts + app.lang.get('LBL_DNB_BI_NEW_ACCT');
                } else if (newAccounts > 0 && duplicates > 0) {
                    level = 'warning',
                    title = app.lang.get('LBL_WARNING');
                    message = app.lang.get('LBL_DNB_BI_YOU_ADD') + newAccounts + app.lang.get('LBL_DNB_BI_NEW_ACCT');
                    message += duplicates + app.lang.get('LBL_DNB_BI_DUP_MSG');
                } else if (newAccounts === 0) {
                    level = 'error',
                    title = app.lang.get('LBL_ERROR');
                    message = app.lang.get('LBL_DNB_BI_ERR');
                }
                if (newAccounts !== 0) {
                    message += viewAcctsHTML;
                }
                app.alert.show('dnb-import', {
                    level: level,
                    title: title + ':',
                    messages: message,
                    autoClose: true,
                    autoCloseDelay: 10000
                });
                callBack.call(self);
            },
            error: function(xhr, status, error) {
                app.alert.dismiss('bulkImport');
                var errorMessage,
                    errorCode = xhr.code;
                if(!_.isUndefined(errorCode)) {
                    errorMessage = app.lang.get(this.commonErrorMap[errorCode]);
                }
                if(_.isUndefined(errorMessage)) {
                    errorMessage = this.commonErrorMap['ERROR_DNB_UNKNOWN'];
                }
                app.alert.show('dnb-import', {
                    level: 'error',
                    title: app.lang.get('LBL_ERROR'),
                    messages: errorMessage,
                    autoClose: true,
                    autoCloseDelay: 10000
                });
            }
        });
    },

    /**
     * Toggle the button between enabled and disabled states
     * @param {Boolean} isDisabled
     * @param {String} selector
     */
    toggleButton: function(isDisabled, selector) {
        this.$(selector).toggleClass('disabled', isDisabled);
        this.$(selector).prop('disabled', isDisabled);
    }
});
