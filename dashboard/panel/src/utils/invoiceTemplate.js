export const formatDate = (value) => {
  if (!value) return '-';
  const date = new Date(value);
  if (Number.isNaN(date.getTime())) return value;
  return new Intl.DateTimeFormat('en-IN', {
    year: 'numeric',
    month: 'short',
    day: '2-digit',
  }).format(date);
};

export const getCustomerAddress = (invoice) =>
  [invoice.customer_address || invoice.customer_city, invoice.customer_state, invoice.customer_pincode]
    .filter(Boolean)
    .join(', ');

export const numberToWords = (num) => {
  const a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
  const b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];
  if ((num = num.toString()).length > 9) return 'overflow';
  let n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
  if (!n) return ''; let str = '';
  str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
  str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
  str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
  str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
  str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'Rupees Only' : 'Rupees Only';
  return str;
};

export const buildInvoiceHtml = ({ invoice }) => {
  const customerAddress = getCustomerAddress(invoice);
  const packing = Number(invoice.packing ?? invoice.shipping ?? 0);
  const itemsHtml = (invoice.items || [])
    .map(
      (item, index) => `
        <tr>
          <td style="width: 7%; text-align: center; padding-left: 6px; padding-right: 6px; white-space: nowrap;">${index + 1}</td>
          <td style="width: 43%; text-align: left; padding-left: 10px;">${item.product_name || `Product #${item.product_id}`}</td>
          <td style="width: 10%;">${item.quantity}</td>
          <td style="width: 15%; text-align: right; padding-right: 15px;">${Number(item.price).toFixed(2)}</td>
          <td style="width: 10%;">-</td>
          <td style="width: 15%; text-align: right; padding-right: 15px;">${Number(item.total || (item.quantity * item.price)).toFixed(2)}</td>
        </tr>
      `
    )
    .join('');

  return `
    <!DOCTYPE html>
    <html>
      <head>
        <title>${invoice.order_no || 'Invoice'}</title>
        <style>
          @page { size: A4 portrait; margin: 5mm; }
          *, *:before, *:after { box-sizing: border-box; }
          html, body { margin: 0; padding: 0; width: 100%; height: 100%; font-family: Arial, sans-serif; color: #000; font-size: 14px; }
          .container { width: 100%; height: 100%; display: flex; flex-direction: column; padding: 0; }
          .bill-box { display: flex; flex-direction: column; flex-grow: 1; border: 2px solid #000; height: 100%; max-height: 287mm; }
          .header-row { border-bottom: 2px solid #000; padding: 10px; text-align: center; position: relative; flex-shrink: 0; }
          .gst-no { position: absolute; top: 5px; right: 10px; font-weight: bold; font-size: 12px; }
          .company-title { font-size: 28px; font-weight: bold; margin: 10px 0 5px; letter-spacing: 1px; }
          .company-address { font-size: 14px; font-weight: bold; line-height: 1.4; }
          .info-row { display: flex; border-bottom: 2px solid #000; flex-shrink: 0; }
          .info-left { width: 50%; border-right: 2px solid #000; padding: 5px 10px; display: flex; flex-direction: column; }
          .info-center { width: 15%; border-right: 2px solid #000; padding: 5px 10px; text-align: center; font-weight: bold; font-size: 14px; }
          .info-right { width: 35%; padding: 5px 10px; font-weight: bold; font-size: 14px; line-height: 1.8; position: relative; }
          .items-wrapper { flex-grow: 1; position: relative; border-bottom: 2px solid #000; display: flex; flex-direction: column; }
          .items-table { width: 100%; border-collapse: collapse; text-align: center; position: relative; z-index: 2; table-layout: fixed; }
          .items-table th { background: #e5e5e5; font-size: 14px; border-bottom: 2px solid #000; border-top: 1px solid #000; border-left: 1px solid #000; padding: 5px; }
          .items-table th:first-child { border-left: none; }
          .items-table td { padding: 5px; border-bottom: none; border-top: none; vertical-align: top; padding-top: 10px; font-size: 14px; }
          .vertical-line { position: absolute; top: 0; bottom: 0; width: 1px; background: #000; z-index: 1; }
          .composition-box { position: absolute; bottom: 10px; left: 8%; background: #000; color: #fff; padding: 2px 5px; font-size: 13px; font-weight: bold; letter-spacing: 1px; z-index: 2; }
          .totals-row { padding: 10px; display: flex; flex-direction: column; align-items: flex-end; border-bottom: 2px solid #000; font-weight: bold; font-size: 15px; gap: 8px; flex-shrink: 0; }
          .dispatch-row { border-bottom: 2px solid #000; padding: 10px; font-size: 14px; line-height: 2.2; font-weight: bold; flex-shrink: 0; }
          .words-row { border-bottom: 2px solid #000; padding: 10px; font-weight: bold; font-size: 15px; flex-shrink: 0; }
          .footer-row { display: flex; justify-content: space-between; padding: 10px; padding-top: 50px; font-weight: bold; font-size: 14px; flex-shrink: 0; }
          .signature-box { text-align: center; }
          .dashed-line { border-bottom: 1px dashed #000; display: inline-block; min-width: 150px; }
        </style>
      </head>
      <body>
        <div class="container">
          <div class="bill-box">
            <div class="header-row">
              <div class="gst-no">GST.No.33AASFC9078N1ZK</div>
              <div class="company-title">C ANNAPOORANI PATTASU KADAI</div>
              <div class="company-address">
                1/205-13, Sattur to Virudhunagar Main Road,<br/>
                Vachakarapatti, R.R.Nagar, Virudhunagar-626 204.
              </div>
            </div>
            
            <div class="info-row">
              <div class="info-left">
                <span>To,</span>
                <strong style="font-size: 16px; margin: 5px 0;">M/S ${invoice.customer_name || 'Walk-in Customer'}</strong>
                <span>${invoice.customer_phone || ''}</span>
                <span>${customerAddress}</span>
                <div style="margin-top: auto;">PARTY'S Adhaar NO:</div>
              </div>
              <div class="info-center">
                HSN-3604
              </div>
              <div class="info-right">
                <div style="display: flex; justify-content: space-between;">
                  <span>CASH / CREDIT</span>
                  <span style="background: yellow; padding: 0 4px; border: 1px solid #000;">INVOICE</span>
                </div>
                <div style="margin-top: 10px;">INVOICE NO : ${invoice.order_no || ''}</div>
                <div>INVOICE DATE : ${formatDate(invoice.order_date || invoice.created_at)}</div>
              </div>
            </div>
            
            <div class="items-wrapper">
              <div class="vertical-line" style="left: 7%;"></div>
              <div class="vertical-line" style="left: 50%;"></div>
              <div class="vertical-line" style="left: 60%;"></div>
              <div class="vertical-line" style="left: 75%;"></div>
              <div class="vertical-line" style="left: 85%;"></div>
              <table class="items-table">
                <thead>
                  <tr>
                    <th style="width: 7%; text-align: center; padding-left: 6px; padding-right: 6px; white-space: nowrap;">S.NO</th>
                    <th style="width: 43%; text-align: left; padding-left: 10px;">Particulars</th>
                    <th style="width: 10%;">Quantity</th>
                    <th style="width: 15%;">Rate<br/>Rs. &nbsp;&nbsp;&nbsp; Ps.</th>
                    <th style="width: 10%;">Per</th>
                    <th style="width: 15%;">Amount<br/>Rs. &nbsp;&nbsp;&nbsp; Ps.</th>
                  </tr>
                </thead>
                <tbody>
                  ${itemsHtml}
                </tbody>
              </table>
              <div class="composition-box">COMPOSITION SCHEME UNDER GST</div>
            </div>
            
            <div class="totals-row">
              <div style="display: flex; width: 300px; justify-content: space-between;">
                <span>Sub Total :</span>
                <span style="padding-right: 15px;">${Number(invoice.sub_total || 0).toFixed(2)}</span>
              </div>
              ${packing > 0 ? `
              <div style="display: flex; width: 300px; justify-content: space-between;">
                <span>Packing :</span>
                <span style="padding-right: 15px;">${packing.toFixed(2)}</span>
              </div>` : ''}
              ${Number(invoice.discount) > 0 ? `
              <div style="display: flex; width: 300px; justify-content: space-between;">
                <span>Discount :</span>
                <span style="padding-right: 15px;">-${Number(invoice.discount).toFixed(2)}</span>
              </div>` : ''}
              ${(invoice.is_gst_applied || invoice.total_gst > 0) ? `
              <div style="display: flex; width: 300px; justify-content: space-between;">
                <span>GST Amount :</span>
                <span style="padding-right: 15px;">${Number(invoice.total_gst).toFixed(2)}</span>
              </div>` : ''}
              <div style="display: flex; width: 300px; justify-content: space-between; font-size: 18px; border-top: 1px dashed #000; padding-top: 8px; margin-top: 4px;">
                <span>TOTAL :</span>
                <span style="padding-right: 15px;">${Number(invoice.total || invoice.grand_total || 0).toFixed(2)}</span>
              </div>
            </div>
            
            <div class="dispatch-row">
              <div>Dispatched Bundies <span class="dashed-line"></span></div>
              <div style="display: flex; justify-content: space-between;">
                <span>From<span class="dashed-line"></span></span>
                <span>Dispatched Through <span class="dashed-line" style="min-width: 250px;"></span></span>
              </div>
            </div>
            
            <div class="words-row">
              Amount in Words <span style="font-weight: normal; margin-left: 10px;">${numberToWords(Math.round(invoice.total || invoice.grand_total || 0))}</span>
            </div>
            
            <div class="footer-row">
              <div class="signature-box">Prepared By</div>
              <div class="signature-box">Created By</div>
              <div class="signature-box" style="text-align: right;">
                <div>For ANNAPOORANI PATTASU KADAI</div>
                <div style="margin-top: 30px;">Partner/Manager</div>
              </div>
            </div>
          </div>
        </div>
      </body>
    </html>
  `;
};
