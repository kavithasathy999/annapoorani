<style>
    /* Shared homepage-inspired polish for inner pages */
    :root {
        --gold: #0b6698;
        --gold-deep: #c92a0d;
        --gold-light: #ff5733;
        --gold-pale: rgba(229, 58, 18, 0.1);
        --saffron: #0b6698;
        --ivory: #FFFFFF;
        --cream: #f9f9f9;
        --sand: #f0f0f0;
        --stone: #e8e8e8;
        --ink-light: #000000;
        --muted-light: rgba(0,0,0,0.68);
        --line-soft: rgba(0,0,0,0.1);
        --line-gold: rgba(229,58,18,0.28);
        --glow-gold: rgba(229,58,18,0.2);
        --shadow-home-lg: 0 28px 80px rgba(0,0,0,0.08);
        --shadow-home-md: 0 18px 48px rgba(0,0,0,0.06);
    }

    body {
        background:
            radial-gradient(circle at 50% 0, rgba(229,58,18,0.06), transparent 34rem),
            var(--ivory);
    }

    .site-main {
        background: var(--ivory);
    }

    .premium-hero,
    .article-hero,
    .seo-hero,
    .terms-hero,
    .estimate-hero,
    .success-hero,
    .bank-hero {
        background: var(--cream);
        isolation: isolate;
    }

    .hero-glass-overlay,
    .seo-hero-overlay,
    .terms-hero-overlay,
    .hero-overlay {
        background:
            radial-gradient(circle at 50% 44%, rgba(229,58,18,0.1), transparent 18rem),
            linear-gradient(to bottom, rgba(255,255,255,0.8), rgba(255,255,255,0.98)) !important;
    }

    .hero-parallax-bg,
    .article-hero-parallax,
    .seo-hero-bg,
    .terms-hero-bg,
    .hero-bg {
        filter: saturate(1.12) contrast(1.05);
    }

    .hero-display-title,
    .article-display-title,
    .seo-hero h1,
    .terms-hero h1,
    .hero-title,
    .success-title,
    .p-title,
    .b-title,
    .c-title {
        color: #000 !important;
        font-weight: 900;
        text-shadow: 0 16px 48px rgba(0,0,0,0.1);
        letter-spacing: 0;
    }

    .hero-display-title span,
    .article-display-title span,
    .seo-hero h1 span,
    .terms-hero h1 span,
    .hero-title span,
    .success-title span,
    .p-title span,
    .b-title span,
    .c-title span {
        background: linear-gradient(135deg, #d5e8fd 0%, #0c689b 50%, #043048 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        filter: drop-shadow(0 0 16px rgba(229,58,18,0.2));
    }

    .hero-eyebrow,
    .section-eyebrow,
    .seo-eyebrow,
    .terms-eyebrow,
    .success-eyebrow,
    .p-eyebrow,
    .b-eyebrow,
    .c-eyebrow,
    .order-modal-eyebrow,
    .method-kicker {
        background: rgba(255,255,255,0.05) !important;
        border: 2px solid var(--line-gold) !important;
        color: var(--gold-light) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 12px !important;
        padding: 8px 24px !important;
        border-radius: 40px !important;
        font-size: 0.75rem !important;
        letter-spacing: 2px !important;
        text-transform: uppercase !important;
        font-weight: 800 !important;
        margin-bottom: 25px !important;
    }

    .hero-sep,
    .section-bar,
    .b-title-sep,
    .p-title-sep,
    .c-bar,
    .s-card-bar,
    .seo-indicator {
        background: linear-gradient(90deg, #ff5733, #0b6698) !important;
        box-shadow: 0 0 12px rgba(229,58,18,0.3);
    }

    .hero-subtitle,
    .hero-sub,
    .section-subtitle,
    .p-subtitle,
    .c-desc,
    .terms-hero p,
    .article-content-rich,
    .seo-rich-content {
        color: var(--muted-light) !important;
    }

    .premium-blog-section,
    .article-body-section,
    .seo-section,
    .terms-section,
    .payment-interface,
    .estimate-content,
    .success-page {
        background:
            radial-gradient(circle at 50% 0, rgba(229,58,18,0.05), transparent 28rem),
            linear-gradient(180deg, rgba(255,255,255,0.98), rgba(249,249,249,0.98)) !important;
    }

    .luxury-blog-card,
    .blog-empty-luxury,
    .premium-article-card,
    .s-card,
    .s-cta-card,
    .seo-main-card,
    .sidebar-card,
    .finance-card,
    .terminal-card,
    .pay-slab,
    .top-summary,
    .search-wrap,
    .table-wrap,
    .contact-form-glass,
    .info-block,
    .step-item-glass {
        background: rgba(255,255,255,0.92) !important;
        border: 1px solid var(--line-gold) !important;
        box-shadow: var(--shadow-home-md);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        position: relative;
    }

    .luxury-blog-card,
    .premium-article-card,
    .s-card,
    .s-cta-card,
    .seo-main-card,
    .sidebar-card,
    .finance-card,
    .terminal-card,
    .pay-slab,
    .info-block,
    .step-item-glass {
        overflow: hidden;
    }

    .luxury-blog-card::before,
    .premium-article-card::before,
    .s-card::before,
    .s-cta-card::before,
    .seo-main-card::before,
    .sidebar-card::before,
    .finance-card::before,
    .terminal-card::before,
    .pay-slab::before,
    .info-block::before,
    .step-item-glass::before {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;
        background:
            linear-gradient(135deg, rgba(0,0,0,0.02), transparent 32%),
            radial-gradient(circle at 85% 0, rgba(229,58,18,0.08), transparent 34%);
        opacity: 0.85;
    }

    .luxury-blog-card:hover,
    .premium-article-card:hover,
    .s-card:hover,
    .s-cta-card:hover,
    .seo-main-card:hover,
    .sidebar-card:hover,
    .finance-card:hover,
    .terminal-card:hover,
    .pay-slab:hover,
    .info-block:hover,
    .step-item-glass:hover {
        transform: translateY(-8px);
        border-color: rgba(229,58,18,0.4) !important;
        box-shadow: var(--shadow-home-lg), 0 0 0 1px rgba(229,58,18,0.08);
    }

    .l-card-title,
    .blog-empty-luxury h3,
    .article-content-rich h2,
    .article-content-rich h3,
    .s-card-title,
    .r-story-info h6,
    .seo-content-header h2,
    .seo-rich-content h3,
    .seo-rich-content h4,
    .sidebar-title,
    .related-content .title,
    .f-account-type,
    .terminal-header,
    .prod-name,
    .product-name,
    .rowTotal,
    .category td,
    .summary-value,
    .qty,
    .cart-item-total {
        color: #000 !important;
    }

    .l-card-excerpt,
    .blog-empty-luxury p,
    .s-card p,
    .r-story-info span,
    .related-content .tag,
    .f-label,
    .method-kicker,
    .showcase-table th,
    .fin-row,
    .slab-meta,
    .summary-label,
    thead th,
    .actual,
    .cart-item-meta,
    .min-order-status,
    .product-row td:nth-child(4) {
        color: rgba(0,0,0,0.62) !important;
    }

    .l-card-link,
    .tag-link,
    .related-content .tag,
    .sidebar-title i,
    .terminal-header i,
    .price,
    .fin-row.total .val,
    .token-id {
        color: #0b6698 !important;
    }

    .video-icon {
        background: #ff4757 !important;
        box-shadow: 0 0 0 2px rgba(255,255,255,0.8), 0 4px 12px rgba(255,71,87,0.3) !important;
    }
    .video-icon::after {
        color: #fff !important;
    }

    .ib-content h6 {
        color: #000 !important;
    }
    .ib-content p,
    .ib-content a {
        color: rgba(0,0,0,0.65) !important;
    }

    .search-wrap input {
        color: #000 !important;
    }
    .search-wrap input::placeholder {
        color: rgba(0,0,0,0.48) !important;
    }
    .clear-search-btn {
        background: rgba(0,0,0,0.08) !important;
        border: 1px solid rgba(0,0,0,0.12) !important;
        color: #000 !important;
    }

    .qty-btn {
        background: #e8e8e8 !important;
        color: #000 !important;
        border: 1px solid rgba(0,0,0,0.15) !important;
    }
    .qty-btn:hover {
        background: #0b6698 !important;
        color: #fff !important;
    }

    .qty-wrapper {
        background: #f0f0f0 !important;
        border: 1px solid rgba(0,0,0,0.1) !important;
    }

    .btn-primary,
    .btn-gold,
    .cta-btn-gold,
    .order-submit-btn,
    .a-btn-gold,
    .qr-action,
    .mobile-sticky-bar {
        background: linear-gradient(135deg, #c92a0d, #0b6698) !important;
        color: #fff !important;
        border: none !important;
        box-shadow: 0 16px 34px rgba(229,58,18,0.28);
        transition: transform .3s ease, box-shadow .3s ease, filter .3s ease;
    }

    .btn-primary:hover,
    .btn-gold:hover,
    .cta-btn-gold:hover,
    .order-submit-btn:hover,
    .a-btn-gold:hover,
    .qr-action:hover,
    .mobile-sticky-bar:hover {
        transform: translateY(-5px);
        filter: brightness(1.08);
        box-shadow: var(--shadow-home-lg), 0 0 0 6px rgba(229,58,18,0.12);
    }

    .btn-outline,
    .btn-outline-gold,
    .a-btn-ghost {
        border-color: var(--line-gold) !important;
        color: #0b6698 !important;
        background: rgba(229,58,18,0.035) !important;
    }

    .btn-outline:hover,
    .btn-outline-gold:hover,
    .a-btn-ghost:hover {
        background: rgba(229,58,18,0.12) !important;
        color: #000 !important;
        transform: translateY(-4px);
    }

    input,
    textarea,
    select,
    .order-input {
        background: rgba(0,0,0,0.04) !important;
        border-color: rgba(0,0,0,0.12) !important;
        /* color: #000 !important; */
    }

    input::placeholder,
    textarea::placeholder {
        /* color: rgba(0,0,0,0.45) !important; */
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #0b6698 !important;
        box-shadow: 0 0 0 4px rgba(229,58,18,0.12) !important;
        outline: none !important;
    }

    .About-footer {
        background:
            radial-gradient(circle at 50% 0, rgba(229,58,18,0.05), transparent 30rem),
            #FFFFFF !important;
        position: relative;
        z-index: 10;
    }

    .f-title::after {
        box-shadow: 0 0 12px rgba(229,58,18,0.3);
    }

    .f-list a:hover,
    .f-contact-item a:hover,
    .f-author a:hover {
        color: #0b6698 !important;
    }

    @media (max-width: 575px) {
        .hero-display-title,
        .article-display-title,
        .seo-hero h1,
        .terms-hero h1,
        .hero-title,
        .success-title {
            font-size: 2.45rem !important;
        }

        .luxury-blog-card,
        .premium-article-card,
        .s-card,
        .s-cta-card,
        .seo-main-card,
        .sidebar-card,
            .finance-card,
        .terminal-card,
        .pay-slab,
        .table-wrap {
            border-radius: 20px !important;
        }
    }
</style>