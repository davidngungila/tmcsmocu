<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Parishioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class CertificateController extends Controller
{
    /**
     * Display certificate log.
     */
    public function index()
    {
        $certificates = Certificate::with('issuedBy')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('certificates.log', compact('certificates'));
    }

    /**
     * Show form to generate finalist certificates.
     */
    public function showFinalistForm()
    {
        $parishioners = Parishioner::orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->orderBy('middle_name', 'asc')
            ->get();
        return view('certificates.finalist', compact('parishioners'));
    }

    /**
     * Generate finalist certificates.
     */
    public function generateFinalist(Request $request)
    {
        $request->validate([
            'selected_parishioners' => 'required|string',
            'description' => 'nullable|string|max:1000',
            'template_name' => 'required|string|max:255',
            'issue_date' => 'required|date',
        ]);

        // Get parishioner IDs from the selected_parishioners string
        $parishionerIds = explode(',', $request->selected_parishioners);
        $parishioners = Parishioner::whereIn('id', $parishionerIds)->get();

        $certificates = [];
        foreach ($parishioners as $parishioner) {
            $certificate = Certificate::create([
                'certificate_number' => Certificate::generateCertificateNumber(),
                'type' => 'finalist',
                'recipient_name' => $parishioner->full_name,
                'description' => $request->description,
                'issue_date' => $request->issue_date,
                'template_name' => $request->template_name,
                'verification_code' => Certificate::generateVerificationCode(),
                'issued_by' => Auth::id(),
            ]);

            // Generate QR code for this certificate
            $qrCode = QrCode::size(150)->generate(route('public.verify.form') . '?code=' . $certificate->verification_code);
            $qrCodePath = 'qr-codes/' . $certificate->id . '.svg';

            // Generate PDF with QR code
            $pdf = PDF::loadView('certificates.finalist-pdf', [
                'certificate' => $certificate,
                'qrCode' => $qrCode,
                'qrCodePath' => $qrCodePath
            ]);

            // Save PDF and QR code
            $pdfPath = 'certificates/' . $certificate->id . '.pdf';
            $pdf->save(public_path($pdfPath));

            // Save QR code as SVG
            file_put_contents(public_path($qrCodePath), $qrCode);

            $certificate->update(['file_path' => $pdfPath]);
            $certificates[] = $certificate;
        }

        return redirect()->route('certificates.log')
            ->with('success', count($certificates) . ' finalist certificates generated successfully!');
    }

    /**
     * Show form to generate group certificates.
     */
    public function showGroupForm()
    {
        $parishioners = Parishioner::orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->orderBy('middle_name', 'asc')
            ->get();
        return view('certificates.group', compact('parishioners'));
    }

    /**
     * Generate group certificates.
     */
    public function generateGroup(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'selected_parishioners' => 'required|string',
            'description' => 'nullable|string|max:1000',
            'template_name' => 'required|string|max:255',
            'issue_date' => 'required|date',
        ]);

        // Get parishioner IDs from the selected_parishioners string
        $parishionerIds = explode(',', $request->selected_parishioners);
        $parishioners = Parishioner::whereIn('id', $parishionerIds)->get();

        $certificates = [];
        foreach ($parishioners as $parishioner) {
            $certificate = Certificate::create([
                'certificate_number' => Certificate::generateCertificateNumber(),
                'type' => 'group',
                'recipient_name' => $parishioner->full_name,
                'group_name' => $request->group_name,
                'description' => $request->description,
                'issue_date' => $request->issue_date,
                'template_name' => $request->template_name,
                'verification_code' => Certificate::generateVerificationCode(),
                'issued_by' => Auth::id(),
            ]);

            // Generate QR code for this certificate
            $qrCode = QrCode::size(150)->generate(route('public.verify.form') . '?code=' . $certificate->verification_code);
            $qrCodePath = 'qr-codes/' . $certificate->id . '.svg';

            // Generate PDF with QR code
            $pdf = PDF::loadView('certificates.group-pdf', [
                'certificate' => $certificate,
                'qrCode' => $qrCode,
                'qrCodePath' => $qrCodePath
            ]);

            // Save PDF and QR code
            $pdfPath = 'certificates/' . $certificate->id . '.pdf';
            $pdf->save(public_path($pdfPath));

            // Save QR code as SVG
            file_put_contents(public_path($qrCodePath), $qrCode);

            $certificate->update(['file_path' => $pdfPath]);
            $certificates[] = $certificate;
        }

        return redirect()->route('certificates.log')
            ->with('success', count($certificates) . ' group certificates generated successfully!');
    }

    /**
     * Show certificate templates.
     */
    public function templates()
    {
        $templates = [
            'standard_finalist' => [
                'name' => 'Standard Finalist Certificate',
                'description' => 'Classic design for individual achievement certificates',
                'preview' => '/images/templates/standard_finalist.jpg'
            ],
            'modern_group' => [
                'name' => 'Modern Group Certificate',
                'description' => 'Contemporary design for group achievement certificates',
                'preview' => '/images/templates/modern_group.jpg'
            ],
            'traditional' => [
                'name' => 'Traditional Certificate',
                'description' => 'Traditional church certificate design',
                'preview' => '/images/templates/traditional.jpg'
            ],
            'achievement' => [
                'name' => 'Achievement Certificate',
                'description' => 'Special achievement recognition design',
                'preview' => '/images/templates/achievement.jpg'
            ],
        ];

        return view('certificates.templates', compact('templates'));
    }

    /**
     * Verify certificate by verification code.
     */
    public function showVerificationForm()
    {
        return view('certificates.verify');
    }

    /**
     * Verify certificate by verification code.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string|max:12',
        ]);

        $certificate = Certificate::where('verification_code', $request->verification_code)
            ->with('issuedBy')
            ->first();

        if (!$certificate) {
            return view('certificates.verification-result-public')->with('error', 'Certificate not found. Please check the verification code.');
        }

        // Mark as verified
        $certificate->update(['is_verified' => true]);

        return view('certificates.verification-result-public', compact('certificate'));
    }

    /**
     * Show certificate details.
     */
    public function show(Certificate $certificate)
    {
        return view('certificates.show', compact('certificate'));
    }

    /**
     * Show user's certificates.
     */
    public function myCertificates()
    {
        $certificates = Certificate::where('recipient_name', Auth::user()->name)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('certificates.my-certificates', compact('certificates'));
    }

    /**
     * Show certificates pending approval.
     */
    public function pendingApproval()
    {
        $certificates = Certificate::where('status', 'draft')
            ->with('issuedBy')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('certificates.pending', compact('certificates'));
    }

    /**
     * Show revoked certificates.
     */
    public function revokedCertificates()
    {
        $certificates = Certificate::where('status', 'revoked')
            ->with('issuedBy')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('certificates.revoked', compact('certificates'));
    }

    /**
     * Bulk download certificates as ZIP.
     */
    public function bulkDownload(Request $request)
    {
        $request->validate([
            'certificates' => 'required|array',
            'certificates.*' => 'exists:certificates,id'
        ]);

        $certificates = Certificate::whereIn('id', $request->certificates)->get();
        $zip = new \ZipArchive();

        $zipFileName = 'certificates_' . now()->format('Y-m-d_H-i-s') . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            foreach ($certificates as $certificate) {
                $qrCode = QrCode::size(150)->generate(route('public.verify.form') . '?code=' . $certificate->verification_code);
                $templateView = $certificate->type === 'finalist' 
                    ? 'certificates.finalist-pdf' 
                    : 'certificates.group-pdf';
                
                $pdf = PDF::loadView($templateView, [
                    'certificate' => $certificate,
                    'qrCode' => $qrCode
                ]);
                
                $filename = $certificate->type . '_certificate_' . $certificate->certificate_number . '.pdf';
                $pdf->save(public_path('temp/' . $filename));
                $zip->addFile(public_path('temp/' . $filename), $filename);
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Show certificate settings.
     */
    public function settings()
    {
        $settings = [
            'auto_approval' => config('certificates.auto_approval', false),
            'send_email' => config('certificates.send_email', false),
            'send_sms' => config('certificates.send_sms', false),
            'default_finalist_template' => config('certificates.default_finalist_template', 'standard_finalist'),
            'default_group_template' => config('certificates.default_group_template', 'modern_group'),
            'default_leadership_template' => config('certificates.default_leadership_template', 'leadership_gold'),
            'default_event_template' => config('certificates.default_event_template', 'event_simple'),
            'certificate_prefix' => config('certificates.certificate_prefix', 'MOCU-STJ-'),
            'expiry_days' => config('certificates.expiry_days', 365),
            'qr_code_size' => config('certificates.qr_code_size', 150),
            'qr_code_position' => config('certificates.qr_code_position', 'bottom-right'),
            'require_approval_finalist' => config('certificates.require_approval_finalist', true),
            'require_approval_group' => config('certificates.require_approval_group', false),
            'require_approval_leadership' => config('certificates.require_approval_leadership', true),
            'require_approval_event' => config('certificates.require_approval_event', false),
            'signature_image' => config('certificates.signature_image', null),
        ];

        return view('certificates.settings', compact('settings'));
    }

    /**
     * Update certificate settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'auto_approval' => 'boolean',
            'send_email' => 'boolean',
            'send_sms' => 'boolean',
            'default_finalist_template' => 'required|string',
            'default_group_template' => 'required|string',
            'default_leadership_template' => 'nullable|string',
            'default_event_template' => 'nullable|string',
            'certificate_prefix' => 'nullable|string|max:50',
            'expiry_days' => 'required|integer|min:0|max:3650',
            'qr_code_size' => 'required|integer|min:50|max:300',
            'qr_code_position' => 'required|string|in:bottom-right,bottom-left,top-right,top-left',
            'require_approval_finalist' => 'boolean',
            'require_approval_group' => 'boolean',
            'require_approval_leadership' => 'boolean',
            'require_approval_event' => 'boolean',
            'signature_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle signature image upload
        if ($request->hasFile('signature_image')) {
            $signaturePath = $request->file('signature_image')->store('signatures', 'public');
            $request->merge(['signature_image' => $signaturePath]);
        }

        // Update settings (you might want to store these in a settings table)
        // For now, we'll just show success message
        return redirect()->route('certificates.settings')
            ->with('success', 'Certificate settings updated successfully!');
    }

    /**
     * Preview certificate.
     */
    public function preview(Certificate $certificate)
    {
        try {
            // Generate QR code for this certificate
            $qrCode = QrCode::size(150)->generate(route('public.verify.form') . '?code=' . $certificate->verification_code);
            
            // Determine which template to use
            $templateView = $certificate->type === 'finalist' 
                ? 'certificates.finalist-pdf' 
                : 'certificates.group-pdf';
            
            // Generate PDF with QR code
            $pdf = PDF::loadView($templateView, [
                'certificate' => $certificate,
                'qrCode' => $qrCode
            ]);
            
            // Save PDF temporarily for preview
            $filename = 'preview_' . $certificate->id . '.pdf';
            $pdfPath = 'temp/' . $filename;
            $pdf->save(public_path($pdfPath));
            
            return response()->json([
                'pdf_url' => asset($pdfPath),
                'certificate_id' => $certificate->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to generate preview: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Revoke certificate.
     */
    public function revoke(Certificate $certificate)
    {
        if ($certificate->status !== 'approved') {
            return back()->with('error', 'Only approved certificates can be revoked.');
        }

        $certificate->update([
            'status' => 'revoked',
            'revoked_at' => now(),
            'revoked_by' => Auth::id()
        ]);

        return back()->with('success', 'Certificate revoked successfully.');
    }

    /**
     * Download certificate PDF.
     */
    public function download(Certificate $certificate)
    {
        // Generate QR code for this certificate
        $qrCode = QrCode::size(150)->generate(route('public.verify.form') . '?code=' . $certificate->verification_code);
        
        // Determine which template to use
        $templateView = $certificate->type === 'finalist' 
            ? 'certificates.finalist-pdf' 
            : 'certificates.group-pdf';
        
        // Generate PDF with QR code
        $pdf = PDF::loadView($templateView, [
            'certificate' => $certificate,
            'qrCode' => $qrCode
        ]);
        
        // Generate filename
        $filename = $certificate->type . '_certificate_' . $certificate->certificate_number . '.pdf';
        
        // Return PDF download
        return $pdf->download($filename);
    }
}
