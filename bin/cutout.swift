import Foundation
import Vision
import CoreImage
import ImageIO
import UniformTypeIdentifiers

// usage: cutout <in> <out.png>   (on-device background removal, Apple Vision)
let args = CommandLine.arguments
guard args.count == 3 else { FileHandle.standardError.write("usage: cutout in out\n".data(using: .utf8)!); exit(2) }
let inURL = URL(fileURLWithPath: args[1]), outURL = URL(fileURLWithPath: args[2])
guard let src = CGImageSourceCreateWithURL(inURL as CFURL, nil), let cg = CGImageSourceCreateImageAtIndex(src, 0, nil) else { print("cannot read image"); exit(1) }
let handler = VNImageRequestHandler(cgImage: cg, options: [:])
let req = VNGenerateForegroundInstanceMaskRequest()
do { try handler.perform([req]) } catch { print("vision failed: \(error)"); exit(1) }
guard let obs = req.results?.first else { print("no foreground found"); exit(1) }
print("instances: \(obs.allInstances.count)")
do {
    let buf = try obs.generateMaskedImage(ofInstances: obs.allInstances, from: handler, croppedToInstancesExtent: false)
    let ci = CIImage(cvPixelBuffer: buf)
    let ctx = CIContext()
    guard let out = ctx.createCGImage(ci, from: ci.extent, format: .RGBA8, colorSpace: CGColorSpace(name: CGColorSpace.sRGB)!) else { print("render failed"); exit(1) }
    guard let dest = CGImageDestinationCreateWithURL(outURL as CFURL, UTType.png.identifier as CFString, 1, nil) else { exit(1) }
    CGImageDestinationAddImage(dest, out, nil)
    if !CGImageDestinationFinalize(dest) { print("write failed"); exit(1) }
    print("ok \(out.width)x\(out.height)")
} catch { print("mask failed: \(error)"); exit(1) }
