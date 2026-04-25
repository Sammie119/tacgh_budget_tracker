@extends('layouts.app')

@section('content')
<style>
    /* ── Page hero ── */
    .rpt-hero {
        background: linear-gradient(135deg, #1a1a6e 0%, #3b2fb5 50%, #6c5ce7 100%);
        border-radius: 20px;
        padding: 40px 44px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
        color: #fff;
    }
    .rpt-hero::before {
        content: '';
        position: absolute;
        width: 420px; height: 420px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        top: -140px; right: -100px;
        pointer-events: none;
    }
    .rpt-hero::after {
        content: '';
        position: absolute;
        width: 260px; height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        bottom: -80px; left: 30%;
        pointer-events: none;
    }
    .rpt-hero-inner { position: relative; z-index: 1; }
    .rpt-hero h2 {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -0.3px;
    }
    .rpt-hero p {
        font-size: 14px;
        opacity: 0.75;
        max-width: 540px;
        line-height: 1.65;
        margin-bottom: 0;
    }
    .rpt-hero-stats {
        display: flex;
        gap: 32px;
        margin-top: 28px;
    }
    .hero-stat-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .hero-stat-val {
        font-size: 22px;
        font-weight: 800;
        line-height: 1;
    }
    .hero-stat-lbl {
        font-size: 11px;
        opacity: 0.6;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .hero-stat-divider {
        width: 1px;
        background: rgba(255,255,255,0.2);
        align-self: stretch;
    }

    /* ── Section title ── */
    .section-heading {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #6c757d;
        margin-bottom: 16px;
    }

    /* ── Report cards ── */
    .rpt-card {
        border: 1.5px solid #e9ecef;
        border-radius: 18px;
        background: #fff;
        padding: 28px 28px 24px;
        transition: transform 0.18s, box-shadow 0.18s, border-color 0.18s;
        cursor: pointer;
        text-decoration: none !important;
        display: block;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    .rpt-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 18px;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .rpt-card.blue-card::before   { background: linear-gradient(135deg, rgba(59,47,181,0.04), rgba(108,92,231,0.06)); }
    .rpt-card.green-card::before  { background: linear-gradient(135deg, rgba(25,135,84,0.04), rgba(13,202,240,0.05)); }
    .rpt-card.amber-card::before  { background: linear-gradient(135deg, rgba(217,119,6,0.04), rgba(245,158,11,0.06)); }
    .rpt-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.10);
    }
    .rpt-card:hover::before { opacity: 1; }
    .rpt-card.blue-card:hover  { border-color: #6c5ce7; }
    .rpt-card.green-card:hover { border-color: #198754; }
    .rpt-card.amber-card:hover { border-color: #d97706; }

    .rpt-card-icon {
        width: 56px; height: 56px;
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
        position: relative; z-index: 1;
    }
    .rpt-card-icon.blue  { background: rgba(108,92,231,0.1); color: #6c5ce7; }
    .rpt-card-icon.green { background: rgba(25,135,84,0.1);  color: #198754; }
    .rpt-card-icon.amber { background: rgba(245,158,11,0.1);  color: #d97706; }

    .rpt-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a3e;
        margin-bottom: 8px;
        position: relative; z-index: 1;
    }
    .rpt-card-desc {
        font-size: 13px;
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 20px;
        position: relative; z-index: 1;
    }

    /* filter pills */
    .rpt-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 22px;
        position: relative; z-index: 1;
    }
    .rpt-filter-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        border: 1px solid;
    }
    .rpt-filter-pill.blue  { background: rgba(108,92,231,0.08); color: #5340b8; border-color: rgba(108,92,231,0.2); }
    .rpt-filter-pill.green { background: rgba(25,135,84,0.08);  color: #145c3a; border-color: rgba(25,135,84,0.2); }
    .rpt-filter-pill.amber { background: rgba(245,158,11,0.08);  color: #92400e; border-color: rgba(245,158,11,0.2); }
    .rpt-filter-pill.req   { opacity: 0.55; }

    .rpt-card-divider {
        border: none;
        border-top: 1px dashed #e9ecef;
        margin-bottom: 20px;
        position: relative; z-index: 1;
    }

    /* outputs row */
    .rpt-outputs {
        display: flex;
        gap: 10px;
        margin-bottom: 22px;
        position: relative; z-index: 1;
    }
    .rpt-output-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 8px;
        background: #f8f9fa;
        color: #495057;
        border: 1px solid #e9ecef;
    }
    .rpt-output-badge .dot {
        width: 6px; height: 6px;
        border-radius: 50%;
    }
    .rpt-output-badge .dot.green { background: #198754; }
    .rpt-output-badge .dot.red   { background: #dc3545; }
    .rpt-output-badge .dot.blue  { background: #0d6efd; }

    /* generate button */
    .rpt-generate-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        height: 44px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: opacity 0.15s, transform 0.12s;
        position: relative; z-index: 1;
    }
    .rpt-generate-btn:active { transform: scale(0.98); }
    .rpt-generate-btn.blue  { background: linear-gradient(135deg, #3b2fb5, #6c5ce7); color: #fff; }
    .rpt-generate-btn.green { background: linear-gradient(135deg, #0f6e56, #198754); color: #fff; }
    .rpt-generate-btn.amber { background: linear-gradient(135deg, #b45309, #d97706); color: #fff; }
    .rpt-generate-btn:hover { opacity: 0.88; }

    /* ── How it works ── */
    .how-section {
        background: #f8f9fa;
        border-radius: 18px;
        padding: 28px 32px;
        margin-top: 32px;
        border: 1px solid #e9ecef;
    }
    .how-steps {
        display: flex;
        gap: 0;
        margin-top: 20px;
        position: relative;
    }
    .how-steps::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        height: 1px;
        background: #dee2e6;
        z-index: 0;
    }
    .how-step {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        z-index: 1;
        padding: 0 12px;
    }
    .how-step-num {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #dee2e6;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        font-weight: 700;
        color: #495057;
        margin-bottom: 12px;
    }
    .how-step.active .how-step-num {
        background: linear-gradient(135deg, #3b2fb5, #6c5ce7);
        border-color: #6c5ce7;
        color: #fff;
    }
    .how-step-title {
        font-size: 13px;
        font-weight: 700;
        color: #1a1a3e;
        margin-bottom: 4px;
    }
    .how-step-desc {
        font-size: 11px;
        color: #6c757d;
        line-height: 1.5;
    }

    /* tip box */
    .tip-box {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: rgba(108,92,231,0.06);
        border: 1px solid rgba(108,92,231,0.2);
        border-radius: 12px;
        padding: 14px 16px;
        margin-top: 20px;
    }
    .tip-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        background: rgba(108,92,231,0.12);
        color: #6c5ce7;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .tip-text { font-size: 12px; color: #4a4a6e; line-height: 1.6; }
    .tip-text strong { color: #3b2fb5; }
</style>

<div class="container">
    <div class="page-inner">

        {{-- breadcrumb --}}
        <div class="page-header">
            <h3 class="fw-bold mb-3">Reports</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Reports</a></li>
            </ul>
        </div>

        <x-notifications :messages="$errors->all()"/>

        {{-- ── Hero ── --}}
        <div class="rpt-hero">
            <div class="rpt-hero-inner">
                <h2><i class="far fa-chart-bar me-3" style="opacity:.85"></i>Financial Reports Centre</h2>
                <p>Generate detailed budget performance reports filtered by category, directorate, or budget period. Export to Excel or PDF for presentations and audits.</p>
                <div class="rpt-hero-stats">
                    <div class="hero-stat-item">
                        <span class="hero-stat-val">3</span>
                        <span class="hero-stat-lbl">Report Types</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat-item">
                        <span class="hero-stat-val">3</span>
                        <span class="hero-stat-lbl">Filter Options</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat-item">
                        <span class="hero-stat-val">2</span>
                        <span class="hero-stat-lbl">Export Formats</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Report type cards ── --}}
        <div class="section-heading">Available Reports</div>

        <div class="row g-4 mb-2">

            {{-- Category Report --}}
            <div class="col-md-4">
                <a href="#"
                   class="rpt-card blue-card"
                   data-bs-toggle="modal"
                   data-bs-target="#exampleModal"
                   data-bs-title="Generate Category Report"
                   data-bs-url="form_create/createCategoryReport"
                   data-bs-size="modal-lg">

                    <div class="rpt-card-icon blue">
                        <i class="fas fa-tags"></i>
                    </div>

                    <div class="rpt-card-title">Category Report</div>

                    <hr class="rpt-card-divider">

                    <div style="font-size:11px; font-weight:600; color:#6c757d; text-transform:uppercase; letter-spacing:.5px; margin-bottom:10px">Outputs</div>
                    <div class="rpt-outputs">
                        <span class="rpt-output-badge"><span class="dot blue"></span> On-screen table</span>
                        <span class="rpt-output-badge"><span class="dot green"></span> Excel (.xlsx)</span>
                        <span class="rpt-output-badge"><span class="dot red"></span> PDF (landscape)</span>
                    </div>

                    <button class="rpt-generate-btn blue" type="button">
                        <i class="fas fa-play-circle"></i>
                        Generate Category Report
                    </button>
                </a>
            </div>

            {{-- Directorate Report --}}
            <div class="col-md-4">
                <a href="#"
                   class="rpt-card green-card"
                   data-bs-toggle="modal"
                   data-bs-target="#exampleModal"
                   data-bs-title="Generate Directorate / Unit Report"
                   data-bs-url="form_create/createDepartmentalReport"
                   data-bs-size="modal-lg">

                    <div class="rpt-card-icon green">
                        <i class="fas fa-building"></i>
                    </div>

                    <div class="rpt-card-title">Directorate / Unit Report</div>

                    <hr class="rpt-card-divider">

                    <div style="font-size:11px; font-weight:600; color:#6c757d; text-transform:uppercase; letter-spacing:.5px; margin-bottom:10px">Outputs</div>
                    <div class="rpt-outputs">
                        <span class="rpt-output-badge"><span class="dot blue"></span> On-screen table</span>
                        <span class="rpt-output-badge"><span class="dot green"></span> Excel (.xlsx)</span>
                        <span class="rpt-output-badge"><span class="dot red"></span> PDF (landscape)</span>
                    </div>

                    <button class="rpt-generate-btn green" type="button">
                        <i class="fas fa-play-circle"></i>
                        Generate Directorate Report
                    </button>
                </a>
            </div>

            {{-- Utilisation Summary Report --}}
            <div class="col-md-4">
                <a href="#"
                   class="rpt-card amber-card"
                   data-bs-toggle="modal"
                   data-bs-target="#exampleModal"
                   data-bs-title="Generate Budget Utilisation Summary"
                   data-bs-url="form_create/createUtilisationReport"
                   data-bs-size="modal-lg">

                    <div class="rpt-card-icon amber">
                        <i class="fas fa-chart-bar"></i>
                    </div>

                    <div class="rpt-card-title">Budget Utilisation Summary</div>

                    <hr class="rpt-card-divider">

                    <div style="font-size:11px; font-weight:600; color:#6c757d; text-transform:uppercase; letter-spacing:.5px; margin-bottom:10px">Outputs</div>
                    <div class="rpt-outputs">
                        <span class="rpt-output-badge"><span class="dot blue"></span> On-screen table</span>
                        <span class="rpt-output-badge"><span class="dot green"></span> Excel (.xlsx)</span>
                        <span class="rpt-output-badge"><span class="dot red"></span> PDF (landscape)</span>
                    </div>

                    <button class="rpt-generate-btn amber" type="button">
                        <i class="fas fa-play-circle"></i>
                        Generate Utilisation Report
                    </button>
                </a>
            </div>
        </div>

        {{-- ── How it works ── --}}
        <div class="how-section">
            <div class="section-heading" style="margin-bottom:4px">How It Works</div>
            <p style="font-size:13px; color:#6c757d; margin-bottom:0">Each report takes seconds to generate — just pick your filters and go.</p>

            <div class="how-steps">
                <div class="how-step active">
                    <div class="how-step-num">1</div>
                    <div class="how-step-title">Choose a report</div>
                    <div class="how-step-desc">Click the report type that matches what you need</div>
                </div>
                <div class="how-step active">
                    <div class="how-step-num">2</div>
                    <div class="how-step-title">Set your filters</div>
                    <div class="how-step-desc">Select category, budget period, and optionally a directorate</div>
                </div>
                <div class="how-step active">
                    <div class="how-step-num">3</div>
                    <div class="how-step-title">Review on screen</div>
                    <div class="how-step-desc">Results load instantly in a detailed table with totals</div>
                </div>
                <div class="how-step active">
                    <div class="how-step-num">4</div>
                    <div class="how-step-title">Export</div>
                    <div class="how-step-desc">Download as Excel or PDF with a single click</div>
                </div>
            </div>

            <div class="tip-box">
                <div class="tip-icon"><i class="fas fa-lightbulb"></i></div>
                <div class="tip-text">
                    <strong>Tip:</strong> On the <strong>Category Report</strong>, leaving the Directorate field blank will return results across <em>all</em> directorates for that category — useful for an organisation-wide view. Use the Directorate filter to narrow down to a specific unit.
                </div>
            </div>
        </div>

    </div>
</div>

<x-call-modal />
@endsection
